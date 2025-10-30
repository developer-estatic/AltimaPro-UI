<?php

namespace App\Livewire;

use App\Models\CrmUserPrivileges;
use App\Models\Brand;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('CRM User Privileges')]
class CrmUserPrivilegesComponent extends Component
{
    public $privileges = [];
    public $brand_id;
    public $user_id;
    public $privilege;
    public $editId = null;

    public $modalVisible = false;

    public function mount()
    {
        $this->loadPrivileges();
    }

    public function loadPrivileges()
    {
        $this->privileges = CrmUserPrivileges::with(['brand', 'user'])->get();
    }

    public function savePrivilege()
    {
        $this->validate([
            'brand_id' => 'required|exists:brands,id',
            'user_id' => 'required|exists:users,id',
            'privilege' => 'required|string|max:255',
        ]);

        if ($this->editId !== null) {
            $privilege = CrmUserPrivileges::find($this->editId);
            if ($privilege) {
                $privilege->update([
                    'brand_id' => $this->brand_id,
                    'user_id' => $this->user_id,
                    'privledge' => $this->privilege,
                ]);
            } else {
                $this->notify('warning', 'Privilege not found!');
                $this->hideModal();
                $this->resetForm();
                return;
            }
        } else {
            CrmUserPrivileges::create([
                'brand_id' => $this->brand_id,
                'user_id' => $this->user_id,
                'privledge' => $this->privilege,
            ]);
        }

        $this->loadPrivileges();
        $action = $this->editId !== null ? 'updated' : 'added';
        $this->notify('success', 'Privilege ' . $action . ' successfully!');
        $this->hideModal();
        $this->resetForm();
    }

    public function editPrivilege($id)
    {
        $this->hideModal();
        $this->openModal();
        $this->modalVisible = true;
        $this->editId = $id;
        $privilege = CrmUserPrivileges::find($id);
        $this->brand_id = $privilege->brand_id;
        $this->user_id = $privilege->user_id;
        $this->privilege = $privilege->privledge;
    }

    public function deletePrivilege($id)
    {
        $privilege = CrmUserPrivileges::find($id);
        if ($privilege) {
            $privilege->delete();
            $this->loadPrivileges();
            $this->notify('success', 'Privilege deleted successfully!');
        } else {
            $this->notify('warning', 'Privilege not found!');
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-privilege');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-privilege');
        $this->resetForm();
        $this->modalVisible = false;
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->reset(['brand_id', 'user_id', 'privilege', 'editId', 'modalVisible']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.crm-user-priviledges', [
            'brands' => Brand::all(),
            'users' => User::all(),
        ]);
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }
}
