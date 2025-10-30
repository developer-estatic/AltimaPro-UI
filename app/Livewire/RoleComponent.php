<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\Permission;
use Livewire\Component;

class RoleComponent extends Component
{
    public $roles = [];
    public $permissions = [];
    public $name;
    public $parent_id;
    public $selectedPermissions = [];
    public $editId = null;

    public function mount()
    {
        $this->loadRoles();
        $this->permissions = Permission::all();
    }

    public function loadRoles()
    {
        $this->roles = Role::with('children')->get();
    }

    public function saveRole()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:roles,id',
        ]);

        if ($this->editId) {
            $role = Role::find($this->editId);
            $role->update(['name' => $this->name, 'parent_id' => $this->parent_id]);
        } else {
            $role = Role::create(['name' => $this->name, 'parent_id' => $this->parent_id]);
        }

        $role->permissions()->sync($this->selectedPermissions);

        $this->resetForm();
        $this->loadRoles();
    }

    public function editRole($id)
    {
        $role = Role::find($id);
        $this->editId = $role->id;
        $this->name = $role->name;
        $this->parent_id = $role->parent_id;
        $this->selectedPermissions = $role->permissions->pluck('id')->toArray();
    }

    public function deleteRole($id)
    {
        Role::destroy($id);
        $this->loadRoles();
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->name = '';
        $this->parent_id = null;
        $this->selectedPermissions = [];
    }

    public function render()
    {
        return view('livewire.role-component');
    }
}
