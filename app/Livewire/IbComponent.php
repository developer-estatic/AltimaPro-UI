<?php

namespace App\Livewire;

use App\Models\Ib;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('IB')]
class IbComponent extends Component
{
    public $ibs = [];
    public $spread_categories = [];
    public $symbol_types = [];
    public $symbol_master_name;
    public $symbol_type;
    public $base_spread_rate;
    public $spread_category;
    public $lot_value;
    public $editId = null;

    public $modalVisible = false;

    public function mount()
    {
        $this->loadIbs();
    }

    public function loadIbs()
    {
        $this->ibs = Ib::get();
        $this->spread_categories = getTypesFromCRMMetaData('ib_type');
        $this->symbol_types = getTypesFromCRMMetaData('symbol_type');
        $this->dispatch('reload-datatable');
    }

    public function saveIb()
    {
        $this->validate([
            'symbol_master_name' => 'required|string|max:255',
            'symbol_type' => 'required',
            'base_spread_rate' => 'required|integer',
            'spread_category' => 'required',
            'lot_value' => 'required|integer',
        ]);

        if ($this->editId !== null) {
            $ib = Ib::find($this->editId);
            if ($ib) {
                $ib->update([
                    'symbol_master_name' => $this->symbol_master_name,
                    'symbol_type_id' => $this->symbol_type,
                    'base_spread_rate' => $this->base_spread_rate,
                    'spread_category_id' => $this->spread_category,
                    'lot_value' => $this->lot_value,
                ]);
            } else {
                $this->notify('warning', 'IB not found!');
                $this->hideModal();
                $this->resetForm();
                return;
            }
        } else {
            $ib = Ib::create([
                'symbol_master_name' => $this->symbol_master_name,
                'symbol_type_id' => $this->symbol_type,
                'base_spread_rate' => $this->base_spread_rate,
                'spread_category_id' => $this->spread_category,
                'lot_value' => $this->lot_value,
            ]);
        }

        $this->loadIbs();
        $action = $this->editId !== null ? 'updated' : 'added';
        $this->notify('success', 'IB ' . $action . ' successfully!');
        $this->hideModal();
        $this->resetForm();
    }

    public function editIb($id)
    {
        $this->hideModal();
        $this->openModal();
        $this->modalVisible = true;
        $this->editId = $id;
        $ib = collect($this->ibs)->firstWhere('id', $id);
        $this->symbol_master_name = $ib->symbol_master_name;
        $this->symbol_type = $ib->symbol_type_id;
        $this->base_spread_rate = $ib->base_spread_rate;
        $this->spread_category = $ib->spread_category_id;
        $this->lot_value = $ib->lot_value;
    }

    public function deleteIb($id)
    {
        $ib = Ib::whereId($id)->first();
        if ($ib) {
            $ib->delete();
            $this->loadIbs();
            $this->notify('success', 'IB deleted successfully!');
        } else {
            $this->notify('warning', 'IB not found!');
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-ib');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-ib');
        $this->resetForm();
        $this->modalVisible = false;
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->reset(['symbol_master_name', 'symbol_type', 'base_spread_rate', 'spread_category', 'lot_value', 'editId', 'modalVisible']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.ib-component');
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }

    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }
}
