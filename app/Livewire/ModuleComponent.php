<?php

namespace App\Livewire;

use App\Models\Module;
use App\Rules\UniqueOrderInMenu;
use Livewire\Component;
use App\Models\Permission;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\MenuComposer;

class ModuleComponent extends Component
{
    public $modules = [];
    public $name;
    public $route = null;
    public $parent_id;
    public $order;
    public $menu_type = 'PRIMARY';
    public $status = 0;
    public $editId = null;
    public $permissions = [];
    public $newPermission = ['name' => '', 'display_name' => ''];
    public $newOrder;
    public $loading = false;


    public $modalVisible = false;

    public function mount()
    {
        $this->loadModules();
    }

    public function loadModules()
    {
        $this->modules = Module::with('permissions', 'children')
            ->orderBy('parent_id')
            ->orderBy('order')
            ->get();
        $this->dispatch('reload-datatable');
    }

    public function saveModule()
    {
        // Only keep selected permissions
        $selectedPermissions = collect($this->permissions)
            ->filter(function ($permission) {
                return isset($permission['selected']) && $permission['selected'];
            })
            ->values();

        $this->validate($this->rules());

        // Ensure 'list' permission is always included
        $hasIndex = false;
        foreach ($selectedPermissions as $permission) {
            if (Str::contains($permission['name'], 'index')) {
                $hasIndex = true;
                break;
            }
        }
        if (!$hasIndex) {
            $selectedPermissions->push([
                'name' => 'index',
                'display_name' => 'View/List',
                'selected' => true
            ]);
        }

        // Automatically add 'update' if 'edit' is selected
        $hasEdit = false;
        $hasUpdate = false;
        /* foreach ($selectedPermissions as $permission) {
            if ($permission['name'] === 'edit') {
                $hasEdit = true;
            }
            if ($permission['name'] === 'update') {
                $hasUpdate = true;
            }
        }
        if ($hasEdit && !$hasUpdate) {
            $selectedPermissions->push([
                'name' => 'update',
                'display_name' => 'Update',
                'selected' => true
            ]);
        } */

        $moduleData = [
            'name' => $this->name,
            'route' => $this->route,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'menu_type' => $this->menu_type,
            'status' => $this->status,
        ];

        if ($this->editId) {
            $module = Module::find($this->editId);
            $module->update($moduleData);
        } else {
            $module = Module::create($moduleData);
        }

        // Sync permissions

        $oldPermissions = Permission::where('module_id', $module->id)->pluck('id')->toArray();
        $newPermissionIds = [];

        $selectedPermissions->map(function ($permission) use ($module, &$newPermissionIds) {

            $route = explode('.', $module->route);
            $name = array_pop($route);

            $route = explode('.', $module->route);
            array_pop($route);
            $route = implode('.', $route);
            $exploded_permission_name = explode('.', $permission['name']);
            if (count($exploded_permission_name) > 1) {
                $permission['name'] = $route . '.' . end($exploded_permission_name);
            } else {
                $permission['name'] = $route . '.' . $permission['name'];
            }

            $newPermissionIds[] = Permission::updateOrCreate(
                [
                    'module_id' => $module->id,
                    'name' => $permission['name'],
                ],
                [
                    'display_name' => $permission['display_name'] ?? ucfirst($permission['name']),
                ]
            )->id;
        });

        $diff = array_diff($oldPermissions, $newPermissionIds);
        if (!empty($diff)) {
            Permission::whereIn('id', $diff)->delete();
        }

        $this->hideModal();
        $this->loadModules();
        $action = $this->editId ? 'updated' : 'added';
        $this->notify('success', 'Module ' . $action . ' successfully!');
    }

    /**
     * Get the validation rules for the module form.
     */
    protected function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'route' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $query = Module::where('route', $value);
                        if ($this->editId) {
                            $query->where('id', '!=', $this->editId);
                        }
                        if ($query->exists()) {
                            $fail('The route already exists.');
                        }
                    }
                },
            ],
            'order' => [
                'required',
                'integer',
                function ($attribute, $value, $fail) {
                    $query = Module::where('menu_type', $this->menu_type)
                        ->where('order', $value)
                        ->where('parent_id', $this->parent_id);

                    if ($this->editId) {
                        $query->where('id', '!=', $this->editId);
                    }

                    if ($query->exists()) {
                        $fail('The order must be unique within the same menu type and parent module.');
                    }
                },
            ],
            'menu_type' => 'required|in:PRIMARY,SECONDARY',
            'status' => 'required|boolean',
            'permissions' => 'array',
        ];
        if ($this->menu_type === 'SECONDARY') {
            $rules['parent_id'] = 'required|exists:modules,id';
        } else {
            $rules['parent_id'] = 'nullable';
        }
        return $rules;
    }

    public function updatedMenuType($value)
    {
        if ($value === 'PRIMARY') {
            $this->parent_id = null;
        }
    }

    public function updatedParentId($value)
    {
        if ($this->menu_type === 'SECONDARY' && ($value === '' || $value === null)) {
            $this->menu_type = 'PRIMARY';
        }
    }



    public function editModule($id)
    {
        $this->hideModal();
        $module = Module::find($id);
        $this->editId = $module->id;
        $this->name = $module->name;
        // If route is empty, generate from name
        if (empty($module->route)) {
            // $generatedRoute = strtolower($module->name);
            // $generatedRoute = preg_replace('/[\s_]+/', '-', $generatedRoute);
            // $generatedRoute = preg_replace('/[^a-z0-9\-]/', '', $generatedRoute);
            // $generatedRoute = preg_replace('/-+/', '-', $generatedRoute);
            // $generatedRoute = trim($generatedRoute, '-');
            // $this->route = $generatedRoute . '.index';
        } else {
            $this->route = $module->route;
        }
        $this->parent_id = $module->parent_id;
        $this->order = $module->order;
        $this->menu_type = $module->menu_type;
        $this->status = $module->status;

        $this->permissions = Permission::where('module_id', $module->id)->get()->toArray();

        if (empty($this->permissions)) {
            $this->permissions = $this->defaultPermissions();
        }

        $this->permissions = array_map(function ($permission) {
            $permission['selected'] = true;
            return $permission;
        }, $this->permissions);
        $this->openModal();
    }

    public function deleteModule($id)
    {
        Module::destroy($id);
        Permission::where('module_id', $id)->delete();
        $this->loadModules();
    }

    public function resetForm()
    {
        $this->name = null;
        $this->route = null;
        $this->parent_id = null;
        $this->order = null;
        $this->menu_type = 'PRIMARY';
        $this->status = 0;
        $this->editId = null;
        $this->permissions = [];
        $this->newPermission = ['name' => '', 'display_name' => ''];
        $this->modalVisible = false;
        $this->dispatch('close-modal', 'create-update-module');
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.module-component');
    }

    public function openModal()
    {
        $this->modalVisible = true;
        if (!$this->editId) {
            $this->permissions = $this->defaultPermissions();
        }
        $this->dispatch('open-modal', 'create-update-module');
    }
    public function openCreateModal()
    {
        $this->resetForm();
        $this->openModal();
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-module');
        $this->resetForm();
        $this->modalVisible = false;
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant' => $variant, 'message' => $message]);
    }

    public function toggleStatus($id)
    {
        $this->loading = true; // Show loading state
        $module = Module::find($id);

        if (!$module) {
            $this->notify('error', 'Module not found.');
            return;
        }

        $module->status = !$module->status;
        $module->save();

        $this->loadModules();
        $this->refreshNavigationMenu();

        $statusText = $module->status ? 'activated' : 'deactivated';
        $this->loading = false; // Hide loading state
        $this->notify('success', "Module {$statusText} successfully!");
    }

    public function updatedStatus($value)
    {
        $this->status = $value === true ? 1 : 0;
    }

    public function defaultPermissions()
    {
        return [
            [
                'name' => 'index',
                'display_name' => 'View/List',
                'selected' => false,
            ],
            [
                'name' => 'show',
                'display_name' => 'Show Single',
                'selected' => false,
            ],
            [
                'name' => 'create',
                'display_name' => 'Create',
                'selected' => false,
            ],
            [
                'name' => 'store',
                'display_name' => 'Store',
                'selected' => false,
            ],
            [
                'name' => 'edit',
                'display_name' => 'Edit',
                'selected' => false,
            ],
            [
                'name' => 'update',
                'display_name' => 'Update',
                'selected' => false,
            ],
            [
                'name' => 'destroy',
                'display_name' => 'Delete',
                'selected' => false,
            ],

        ];
    }

    public function updateOrder($id, $newOrder)
    {
        $this->newOrder = $newOrder; // Assign to public property

        $module = Module::find($id);

        if (!$module) {
            $this->notify('error', 'Module not found.');
            return;
        }

        $this->validate([
            'newOrder' => [
                'required',
                'integer',
                'min:1'
            ],
        ], [
            'newOrder.required' => 'The order field is required.',
            'newOrder.integer' => 'The order must be a valid number.',
            'newOrder.min' => 'The order must be at least 1.',
        ]);

        $this->validate([
            'newOrder' => [new UniqueOrderInMenu($module, $id)],
        ]);

        $module->order = $this->newOrder;
        $module->save();

        $this->loadModules();
        $this->refreshNavigationMenu();
        $this->notify('success', 'Order updated successfully!');
    }

    #[\Livewire\Attributes\On('updateOrderAndParent')]
    public function updateOrderAndParent($value)
    {
        $this->loading = true; // Show loading state
        $data = $value;
        foreach ($data as $key => $item) {
            Module::where('id', $item['id'])->update([
                'order' => $item['order'],
                'parent_id' => $item['parent_id'] ?? null,
            ]);
        }

        $this->loadModules();
        $this->refreshNavigationMenu();
        $this->loading = false; // Hide loading state
        $this->notify('success', 'Order updated successfully!');
    }

    /**
     * Refresh the navigation menu by clearing view cache
     * This ensures the MenuComposer reloads fresh data
     */
    private function refreshNavigationMenu()
    {
        // Clear view cache to force MenuComposer to reload

        $this->dispatch('menu-updated')->to(Menu::class);

        // Alternative approach: Dispatch a browser event to refresh the page
        // $this->dispatch('refresh-navigation');
    }
}
