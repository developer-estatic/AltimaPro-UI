<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Country;
use Livewire\Component;
use App\Models\WhitelistedCountry;

class WhitelistedCountriesComponent extends Component
{
    public $whitelistedCountries;
    public $countriesList;
    public $brands;
    public $brand;
    public $name;
    public $status = 0;
    public $countries;
    public $editId;

    public function mount()
    {
        $this->whitelistedCountries = $this->getWhitelistedCountries();
        $this->countriesList = Country::all();
        $this->brands = Brand::all();
    }

    public function getWhitelistedCountries()
    {
        return WhitelistedCountry::with('brand')->get();
    }

    public function openModal()
    {
        $this->dispatch('open-modal', 'create-update-whitelisted-country');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->resetInputFields();
        $this->resetValidation();
        $this->dispatch('close-modal', 'create-update-whitelisted-country');
    }

    public function saveWhitelistedCountry()
    {
        $this->validate([
            'brand' => 'nullable|exists:brands,id',
            'countries' => 'required|array',
            'countries.*' => 'exists:countries,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        WhitelistedCountry::updateOrCreate(
            ['id' => $this->editId],
            [
                'brand_id' => $this->brand,
                'countries' => $this->countries,
                'name' => $this->name,
                'status' => $this->status,
            ]
        );

        $this->whitelistedCountries = $this->getWhitelistedCountries();
        $action = $this->editId !== null ? 'updated' : 'added';
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Whitelisted country successfully $action.",
        ]);
        $this->hideModal();
    }

    public function editWhitelistedCountry($id)
    {
        $country = WhitelistedCountry::findOrFail($id);
        $this->openModal();
        $this->editId = $country->id;
        $this->brand = $country->brand_id;
        $this->name = $country->name;
        $this->status = $country->status;
        $this->countries = $country->countries;
    }

    public function deleteWhitelistedCountry($id)
    {
        WhitelistedCountry::findOrFail($id)->delete();
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Whitelisted country deleted successfully.',
        ]);
        $this->whitelistedCountries = $this->getWhitelistedCountries();
    }

    public function resetInputFields()
    {
        $this->editId = null;
        $this->brand = null;
        $this->countries = [];
        $this->name = null;
        $this->status = 0;
    }

    public function render()
    {
        return view('livewire.whitelisted-countries-component');
    }

    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }

    public function updatedStatus($value)
    {
        $this->status = $value === true ? 1 : 0;
    }
}
