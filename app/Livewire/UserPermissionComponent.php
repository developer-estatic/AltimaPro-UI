<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Livewire\Component;

class UserPermissionComponent extends Component
{
    public $users = [];
    public $roles = [];
    public $permissions = [];
    public $user_id;
    public $role_id;
    public $selectedPermissions = [];

    public function mount()
    {
        $this->users = User::all();
        $this->roles = Role::all();
        $this->permissions = Permission::all();
    }

    public function saveUserPermissions()
    {
        $this->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'nullable|exists:roles,id',
        ]);

        $user = User::find($this->user_id);

        if ($this->role_id) {
            $user->role_id = $this->role_id;
            $user->save();
        }

        $user->permissions()->sync($this->selectedPermissions);

        $this->resetForm();
    }

    private function resetForm()
    {
        $this->user_id = null;
        $this->role_id = null;
        $this->selectedPermissions = [];
    }

    public function render()
    {
        return view('livewire.user-permission-component');
    }
}
