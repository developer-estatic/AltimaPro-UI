<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use App\Models\Brand;
use App\Models\Module;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\RoleHasPermission;
use App\Models\UserHasPermission;
use Illuminate\Support\Facades\DB;

class RoleManagementComponent extends Component
{
    use WithPagination;

    public $roles;
    public $modules;
    public $name;
    public $parent_id;
    public $editId = null;
    public $modalVisible = false;
    public $selectedBrand = null;
    public $menuAccess = [];
    public $privileges = [];
    public $brands;
    public $selectedMenuItems = [];
    public $selectedPrivileges = [];
    public $modulesWithoutParentFiltered;
    public $lastActionName = null;
    public $selectedRoleOrUser = null;
    public $roleUsers = [];
    public $selectedRoleUsers = [];

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->roles = Role::get();

        $this->modules = Module::with('children', 'permissions')->has('permissions')->where('parent_id', null)->where('status', 1)->get();
        $this->brands = Brand::where('status', 1)->get();
        $this->modulesWithoutParentFiltered = Module::with('permissions')
            ->where('status', 1)
            ->get();
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $role = Role::find($id);
            $this->editId = $role->id;
            $this->name = $role->name;
            $this->parent_id = $role->parent_id;
        }
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-role');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-role');
        $this->dispatch('close-modal', 'menu-access-modal');
        $this->dispatch('close-modal', 'privileges-modal');
        $this->dispatch('close-modal', 'give-permission-to-role-or-user-modal');
        $this->resetForm();
        $this->modalVisible = false;
    }

    public function saveRole()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable',
        ]);

        if ($this->editId) {
            $role = Role::find($this->editId);
            $role->name = $this->name;
            $role->parent_id = $this->parent_id ?? null;
            $role->save();
        } else {
            $role = Role::create([
                'name' => $this->name,
                'parent_id' => $this->parent_id,
            ]);
        }
        $this->loadData();
        $action = $this->editId ? 'updated' : 'added';
        $this->notify('success', 'Role ' . $action . ' successfully!');
        $this->hideModal();
    }

    public function deleteRole($id)
    {
        Role::where('id', $id)->delete();
        $this->loadData();
        $this->notify('success', 'Role deleted successfully');
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->name = '';
        $this->parent_id = null;
        $this->editId = null;
        $this->modalVisible = false;
        $this->selectedBrand = null;
        $this->menuAccess = [];
        $this->privileges = [];
        $this->selectedMenuItems = [];
        $this->selectedPrivileges = [];
        $this->lastActionName = null;
        $this->selectedRoleOrUser = null;
        $this->roleUsers = [];
        $this->selectedRoleUsers = [];
    }


    public function render()
    {
        return view('livewire.role-management-component');
    }

    public function openMenuAccessModal($id)
    {
        $this->resetForm();
        $this->editId = $id;
        $this->selectedBrand = null;
        $this->dispatch('open-modal', 'menu-access-modal');
    }

    public function openPrivilegesModal($id)
    {
        $this->resetForm();
        $this->editId = $id;
        $this->selectedBrand = null;
        $this->dispatch('open-modal', 'privileges-modal');
    }

    public function closeMenuAccessModal($id)
    {
        $this->resetForm();
        $this->editId = null;
        $this->selectedBrand = null;
        $this->dispatch('close-modal', 'menu-access-modal');
    }

    public function closePrivilegesModal($id)
    {
        $this->resetForm();
        $this->editId = null;
        $this->selectedBrand = null;
        $this->dispatch('close-modal', 'privileges-modal');
    }

    public function openGivePermissionToRoleOrUserModal()
    {
        $this->dispatch('close-modal', 'menu-access-modal');
        $this->dispatch('close-modal', 'privileges-modal');
        $this->dispatch('open-modal', 'give-permission-to-role-or-user-modal');
    }

    public function saveMenuAccess($checked = false)
    {
        if (!$checked) {
            $this->selectedRoleOrUser = null;
            $this->roleUsers = [];
            $this->lastActionName = 'saveMenuAccess';
            $this->openGivePermissionToRoleOrUserModal();
            return;
        }
        $this->validate([
            'selectedBrand' => 'required|exists:brands,id',
            'selectedMenuItems' => 'array',
            'selectedRoleOrUser' => 'required|in:role,user',
            'selectedRoleUsers' => 'required_if:selectedRoleOrUser,user|array',
            'selectedRoleUsers.*' => 'exists:users,id',
        ]);

        if ($this->selectedRoleOrUser === 'user') {
            $this->setMenuAccessPermissionToUsers();
            return;
        }


        $oldPermissions = RoleHasPermission::where('role_id', $this->editId)
            ->where('brand_id', $this->selectedBrand)
            ->where('permission_type', 'menu')
            ->pluck('id')
            ->toArray();

        $newPermissionIds = [];


        collect($this->selectedMenuItems)->map(function ($permissionId) use (&$newPermissionIds) {
            $newPermissionIds[] = RoleHasPermission::updateOrCreate(
                [
                    'role_id' => $this->editId,
                    'brand_id' => $this->selectedBrand,
                    'permission_id' => $permissionId,
                    'permission_type' => 'menu'
                ],
                [] // No additional fields to update
            )->id;
        });

        $diff = array_diff($oldPermissions, $newPermissionIds);

        if (!empty($diff)) {
            // Delete old permissions that are no longer selected
            RoleHasPermission::whereIn('id', $diff)->delete();
        }

        $this->hideModal();
        $this->notify('success', 'Menu access updated successfully');
    }

    public function savePrivileges($checked = false)
    {
        if (!$checked) {
            $this->selectedRoleOrUser = null;
            $this->roleUsers = [];
            $this->lastActionName = 'savePrivileges';
            $this->openGivePermissionToRoleOrUserModal();
            return;
        }
        $this->validate([

            'selectedBrand' => 'required|exists:brands,id',
            'selectedPrivileges' => 'array',
            'selectedRoleOrUser' => 'required|in:role,user',
            'selectedRoleUsers' => 'required_if:selectedRoleOrUser,user|array',
            'selectedRoleUsers.*' => 'exists:users,id',
        ]);

        if ($this->selectedRoleOrUser === 'user') {
            $this->setPrivilegesPermissionToUsers();
            return;
        }

        $oldPermissions = RoleHasPermission::where('role_id', $this->editId)
            ->where('brand_id', $this->selectedBrand)
            ->whereIn('permission_type', ['action', 'menu'])
            ->pluck('id')
            ->toArray();

        $newPermissionIds = [];


        collect($this->selectedPrivileges)->map(function ($permissionId) use (&$newPermissionIds) {
            $newPermissionIds[] = RoleHasPermission::updateOrCreate(
                [
                    'role_id' => $this->editId,
                    'brand_id' => $this->selectedBrand,
                    'permission_id' => $permissionId,
                    'permission_type' => in_array($permissionId, $this->selectedMenuItems) ? 'menu' : 'action'
                ],
                []
            )->id;
        });

        $diff = array_diff($oldPermissions, $newPermissionIds);

        if (!empty($diff)) {
            // Delete old permissions that are no longer selected
            RoleHasPermission::whereIn('id', $diff)->delete();
        }

        $this->closePrivilegesModal($this->editId);
        $this->notify('success', 'Privileges updated successfully');
    }

    public function updatedSelectedRoleOrUser($value)
    {
        if ($value === 'user') {
            $this->roleUsers = User::whereHas('roles', function ($query) {
                $query->where('id', $this->editId);
            })
                ->get()
                ->map(function ($user) {
                    return [
                        'id' => $user->id,
                        'name' => $user->name,
                    ];
                })->toArray();
        }
    }
    public function updatedSelectedBrand($value)
    {
        $this->selectedMenuItems = [];
        $this->selectedMenuItems = RoleHasPermission::where('role_id', $this->editId)
            ->where('brand_id', $value)
            ->where('permission_type', 'menu')
            ->pluck('permission_id')
            ->toArray();

        $this->selectedPrivileges = [];
        $this->selectedPrivileges = RoleHasPermission::where('role_id', $this->editId)
            ->where('brand_id', $value)
            ->whereIn('permission_type', ['menu', 'action'])
            ->pluck('permission_id')
            ->toArray();
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant' => $variant, 'message' => $message]);
    }

    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }

    public function setMenuAccessPermissionToUsers()
    {

        foreach ($this->selectedRoleUsers as $userId) {
            $oldPermissions = UserHasPermission::where('user_id', $userId)
                ->where('brand_id', $this->selectedBrand)
                ->where('permission_type', 'menu')
                ->pluck('id')
                ->toArray();

            $newPermissionIds = [];

            collect($this->selectedMenuItems)->map(function ($permissionId) use ($userId, &$newPermissionIds) {
                $newPermissionIds[] = UserHasPermission::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'brand_id' => $this->selectedBrand,
                        'permission_id' => $permissionId,
                        'permission_type' => 'menu'
                    ],
                    [] // No additional fields to update
                )->id;
            });

            $diff = array_diff($oldPermissions, $newPermissionIds);

            if (!empty($diff)) {
                // Delete old permissions that are no longer selected
                UserHasPermission::whereIn('id', $diff)->delete();
            }
        }
        $this->hideModal();
        $this->notify('success', 'Menu access permissions for selected users updated successfully!');
    }
    public function setPrivilegesPermissionToUsers()
    {

        foreach ($this->selectedRoleUsers as $userId) {
            $oldPermissions = UserHasPermission::where('user_id', $userId)
                ->where('brand_id', $this->selectedBrand)
                ->whereIn('permission_type', ['action', 'menu'])
                ->pluck('id')
                ->toArray();

            $newPermissionIds = [];


            collect($this->selectedPrivileges)->map(function ($permissionId) use (&$newPermissionIds, $userId) {
                $newPermissionIds[] = UserHasPermission::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'brand_id' => $this->selectedBrand,
                        'permission_id' => $permissionId,
                        'permission_type' => in_array($permissionId, $this->selectedMenuItems) ? 'menu' : 'action'
                    ],
                    []
                )->id;
            });

            $diff = array_diff($oldPermissions, $newPermissionIds);

            if (!empty($diff)) {
                // Delete old permissions that are no longer selected
                UserHasPermission::whereIn('id', $diff)->delete();
            }
        }
        $this->hideModal();
        $this->notify('success', 'Privileges permissions for selected users updated successfully!');
    }
}
