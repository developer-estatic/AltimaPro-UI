<?php

namespace App\Livewire;

use App\Models\Permission;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Permissions')]
class PermissionComponent extends Component
{
    public $permissionsList = [];
    public $name;
    public $display_name;
    public $module_id;
    public $editId = null;
    public $modalVisible = false;
    public $modules;

    public function mount()
    {
        $this->permissionsList = Permission::all();
        $this->modules = \App\Models\Module::all();
    }

    public function savePermission()
    {
        $this->validate([
            'module_id' => 'required|exists:modules,id',
            'name' => 'required|string|max:255',
            'display_name' => 'required|string|max:255',
        ]);

        if ($this->editId !== null) {
            Permission::find($this->editId)->update([
                'module_id' => $this->module_id,
                'name' => $this->name,
                'display_name' => $this->display_name,
            ]);
        } else {
            Permission::create([
                'module_id' => $this->module_id,
                'name' => $this->name,
                'display_name' => $this->display_name,
            ]);
        }
        $this->permissionsList = Permission::all();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => $this->editId ? 'Permission updated successfully!' : 'Permission created successfully!',
        ]);
        $this->resetForm();
        $this->hideModal();
    }

    public function deletePermission($id)
    {
        Permission::find($id)?->delete();
        $this->permissionsList = Permission::all();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Permission deleted successfully!',
        ]);
    }

    public function editPermission($id)
    {
        $permission = Permission::find($id);
        if ($permission) {
            $this->openModal();
            $this->editId = $permission->id;
            $this->module_id = $permission->module_id;
            $this->name = $permission->name;
            $this->display_name = $permission->display_name;
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-permission');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->modalVisible = false;
        $this->dispatch('close-modal', 'create-update-permission');
        $this->resetValidation();
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->module_id = null;
        $this->name = '';
        $this->display_name = '';
        $this->editId = null;
    }

    public function render()
    {
        return view('livewire.permission-component', [
            'permissions' => $this->permissionsList,
        ]);
    }
}
