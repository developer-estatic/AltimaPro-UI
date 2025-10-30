<?php

namespace App\Livewire;

use App\Models\TradingGroup;
use App\Models\TradingAccountType;
use App\Models\TradingCurrency;
use App\Models\BusinessUnit;
use App\Models\TradingPlatform;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Trading Groups')]
class TradingGroupsComponent extends Component
{
    use WithPagination;

    public $tradingGroups = [];
    public $name;
    public $status = 0;
    public $trading_account_type_id;
    public $trading_currency_id;
    public $business_unit_id;
    public $trading_platform_id;
    public $editId = null;
    public $modalVisible = false;

    public $tradingAccountTypeOptions = [];
    public $tradingCurrencyOptions = [];
    public $businessUnitOptions = [];
    public $tradingPlatformOptions = [];

    public function mount()
    {
        $this->loadTradingGroups();
        $this->loadOptions();
    }

    public function loadTradingGroups()
    {
        $this->tradingGroups = TradingGroup::all();
    }

    public function loadOptions()
    {
        $this->tradingAccountTypeOptions = TradingAccountType::all(['id', 'name'])->map(fn($item) => ['id' => $item->id, 'name' => $item->name])->toArray();
        $this->tradingCurrencyOptions = TradingCurrency::all(['id', 'name'])->map(fn($item) => ['id' => $item->id, 'name' => $item->name])->toArray();
        $this->businessUnitOptions = BusinessUnit::all(['id', 'name'])->map(fn($item) => ['id' => $item->id, 'name' => $item->name])->toArray();
        $this->tradingPlatformOptions = TradingPlatform::all(['id', 'username'])->map(fn($item) => ['id' => $item->id, 'name' => $item->username])->toArray();
    }

    public function saveTradingGroup()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'trading_account_type_id' => 'nullable|integer',
            'trading_currency_id' => 'nullable|integer',
            'business_unit_id' => 'nullable|integer',
            'trading_platform_id' => 'nullable|integer',
        ]);

        if ($this->editId !== null) {
            $group = TradingGroup::find($this->editId);
            if ($group) {
                $group->update([
                    'name' => $this->name,
                    'status' => $this->status,
                    'trading_account_type_id' => $this->trading_account_type_id,
                    'trading_currency_id' => $this->trading_currency_id,
                    'business_unit_id' => $this->business_unit_id,
                    'trading_platform_id' => $this->trading_platform_id,
                ]);
            }
        } else {
            TradingGroup::create([
                'name' => $this->name,
                'status' => $this->status,
                'trading_account_type_id' => $this->trading_account_type_id,
                'trading_currency_id' => $this->trading_currency_id,
                'business_unit_id' => $this->business_unit_id,
                'trading_platform_id' => $this->trading_platform_id,
            ]);
        }

        $this->loadTradingGroups();
        $this->hideModal();
        $this->resetForm();
    }

    public function editTradingGroup($index)
    {
        $this->resetForm();
        $this->modalVisible = true;
        $this->editId = $index;
        $group = TradingGroup::find($this->editId);
        $this->name = $group->name;
        $this->status = $group->status;
        $this->trading_account_type_id = $group->trading_account_type_id;
        $this->trading_currency_id = $group->trading_currency_id;
        $this->business_unit_id = $group->business_unit_id;
        $this->trading_platform_id = $group->trading_platform_id;
        $this->dispatch('open-modal', 'create-update-trading-group');
    }

    public function deleteTradingGroup($index)
    {
        if (isset($this->tradingGroups[$index]['id'])) {
            $group = TradingGroup::find($this->tradingGroups[$index]['id']);
            if ($group) {
                $group->delete();
            }
        }
        $this->loadTradingGroups();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-trading-group');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-trading-group');
        $this->resetForm();
        $this->modalVisible = false;
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->reset(['name', 'status', 'trading_account_type_id', 'trading_currency_id', 'business_unit_id', 'trading_platform_id']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.trading-groups-component');
    }

    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }
}
