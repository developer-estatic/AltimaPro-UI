<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use App\Models\BusinessUnit;

#[\Livewire\Attributes\Layout('layouts.app')]
#[\Livewire\Attributes\Title('Business Units')]
class BusinessUnitsComponent extends Component
{
    public $tradingLeverageOptions = [];
    public $tradingPlatformOptions = [];
    public $brandOptions = [];
    public $parentBusinessUnitOptions = [];

    public $businessUnits = [];
    public $brand_id;
    public $name;
    public $status = 0;
    public $timezone;
    public $language;
    public $isparent = true;
    public $parent_business_unit_id = null;
    public $ftd_amount;
    public $partial_ftd = false;
    public $s3_bucket_name;
    public $s3_bucket_path;
    public $ispamm = false;
    public $issocial = false;
    public $isprop = false;
    public $trading_leverage = null;
    public $trading_platform_id = null;

    public $editIndex = null;
    public $modalVisible = false;

    public function mount()
    {
        $this->loadParentBusinessUnitOptions();
        $this->loadTradingLeverageOptions();
        $this->loadTradingPlatformOptions();
        $this->loadBrandOptions();
        $this->businessUnits = BusinessUnit::all();
    }

    public function loadTradingLeverageOptions()
    {
        $this->tradingLeverageOptions = \App\Models\TradingLeverage::all(['id', 'name'])->map(fn($item) => ['id' => $item->id, 'name' => $item->name])->toArray();
    }

    public function loadTradingPlatformOptions()
    {
        $this->tradingPlatformOptions = \App\Models\TradingPlatform::all(['id', 'username'])->map(fn($item) => ['id' => $item->id, 'name' => $item->username])->toArray();
    }

    public function loadBrandOptions()
    {
        $this->brandOptions = Brand::all(['id', 'name'])->map(fn($item) => ['id' => $item->id, 'name' => $item->name])->toArray();
    }

    public function loadParentBusinessUnitOptions()
    {
        $this->parentBusinessUnitOptions = BusinessUnit::all(['id', 'name'])->map(fn($item) => [
            'id' => $item->id,
            'name' => $item->name,
        ])->toArray();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-business-unit');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-business-unit');
        $this->modalVisible = false;
        $this->resetForm();
    }

    public function saveBusinessUnit()
    {
        $this->validate([
            'brand_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'timezone' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'isparent' => 'required|boolean',
            'parent_business_unit_id' => 'required_if:isparent,false|nullable|integer|exists:business_units,id',
            'ftd_amount' => 'nullable|numeric',
            'partial_ftd' => 'nullable|boolean',
            's3_bucket_name' => 'nullable|string|max:255',
            's3_bucket_path' => 'nullable|string|max:255',
            'ispamm' => 'nullable|boolean',
            'issocial' => 'nullable|boolean',
            'isprop' => 'nullable|boolean',
            'trading_leverage' => 'nullable|integer',
            'trading_platform_id' => 'nullable|integer',
        ]);

        $data = [
            'brand_id' => $this->brand_id,
            'name' => $this->name,
            'status' => $this->status,
            'timezone' => $this->timezone,
            'language' => $this->language,
            'isparent' => $this->isparent,
            'parent_business_unit_id' => $this->isparent ? null : $this->parent_business_unit_id,
            'ftd_amount' => $this->ftd_amount,
            'partial_ftd' => $this->partial_ftd,
            's3_bucket_name' => $this->s3_bucket_name,
            's3_bucket_path' => $this->s3_bucket_path,
            'ispamm' => $this->ispamm,
            'issocial' => $this->issocial,
            'isprop' => $this->isprop,
            'trading_leverage' => $this->trading_leverage,
            'trading_platform_id' => $this->trading_platform_id,
        ];

        if ($this->editIndex !== null) {
            BusinessUnit::find($this->editIndex)->update($data);
        } else {
            BusinessUnit::create($data);
        }

        $this->businessUnits = BusinessUnit::all();
        $this->hideModal();
        $action = $this->editIndex !== null ? 'updated' : 'added';
        $this->notify('success', 'Business unit ' . $action . ' successfully!');
    }

    public function deleteBusinessUnit($id)
    {
        BusinessUnit::find($id)?->delete();
        $this->businessUnits = BusinessUnit::all();
        $this->notify('success', 'Business unit deleted successfully!');
    }

    public function editBusinessUnit($id)
    {
        $unit = BusinessUnit::find($id);
        if ($unit) {
            $this->openModal();
            $this->editIndex = $unit->id;
            $this->brand_id = $unit->brand_id;
            $this->name = $unit->name;
            $this->status = $unit->status;
            $this->timezone = $unit->timezone;
            $this->language = $unit->language;
            $this->isparent = $unit->isparent;
            $this->parent_business_unit_id = $unit->parent_business_unit_id;
            $this->ftd_amount = $unit->ftd_amount;
            $this->partial_ftd = $unit->partial_ftd;
            $this->s3_bucket_name = $unit->s3_bucket_name;
            $this->s3_bucket_path = $unit->s3_bucket_path;
            $this->ispamm = $unit->ispamm;
            $this->issocial = $unit->issocial;
            $this->isprop = $unit->isprop;
        }
    }

    private function resetForm()
    {
        $this->brand_id = null;
        $this->name = '';
        $this->status = 0;
        $this->timezone = '';
        $this->language = '';
        $this->isparent = true;
        $this->parent_business_unit_id = null;
        $this->ftd_amount = null;
        $this->partial_ftd = false;
        $this->s3_bucket_name = '';
        $this->s3_bucket_path = '';
        $this->ispamm = false;
        $this->issocial = false;
        $this->isprop = false;
        $this->trading_leverage = null;
        $this->trading_platform_id = null;
        $this->editIndex = null;
    }

    public function render()
    {
        return view('livewire.business-units-component');
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
}
