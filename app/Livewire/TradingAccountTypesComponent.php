<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TradingAccountType;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Trading Account Types')]
class TradingAccountTypesComponent extends Component
{
    use WithPagination;

    public $tradingAccountTypes = [];
    public $name;
    public $value;
    public $status = 0;
    public $editId = null;

    public $modalVisible = false;

    public function mount()
    {
        $this->loadTradingAccountTypes();
    }

    public function loadTradingAccountTypes()
    {
        $this->tradingAccountTypes = TradingAccountType::get();
    }

    public function saveTradingAccountType()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($this->editId !== null) {
            $type = TradingAccountType::find($this->editId);
            if ($type) {
                $type->update([
                    'name' => $this->name,
                    'value' => $this->value,
                    'status' => $this->status,
                ]);
            } else {
                $this->notify('warning', 'Trading Account Type not found!');
                $this->hideModal();
                $this->resetForm();
                return;
            }
        } else {
            TradingAccountType::create([
                'name' => $this->name,
                'value' => $this->value,
                'status' => $this->status,
            ]);
        }

        $this->loadTradingAccountTypes();
        $action = $this->editId !== null ? 'updated' : 'added';
        $this->notify('success', 'Trading Account Type ' . $action . ' successfully!');
        $this->hideModal();
        $this->resetForm();
    }

    public function updatedStatus($value)
    {
        $this->status = $value === true ? 1 : 0;
    }

    public function editTradingAccountType($id)
    {
        $this->hideModal();
        $this->openModal();
        $this->modalVisible = true;
        $this->editId = $id;
        $type = collect($this->tradingAccountTypes)->firstWhere('id', $id);
        $this->name = $type->name;
        $this->value = $type->value;
        $this->status = $type->status;
    }

    public function deleteTradingAccountType($id)
    {
        $type = TradingAccountType::whereId($id)->first();
        if ($type) {
            $type->delete();
            $this->loadTradingAccountTypes();
            $this->notify('success', 'Trading Account Type deleted successfully!');
        } else {
            $this->notify('warning', 'Trading Account Type not found!');
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-trading-account-type');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-trading-account-type');
        $this->resetForm();
        $this->modalVisible = false;
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->reset(['name', 'value', 'status', 'editId', 'modalVisible']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.trading-account-types-component');
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }
}
