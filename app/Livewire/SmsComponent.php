<?php

namespace App\Livewire;

use App\Models\Sms;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('SMS')]
class SmsComponent extends Component
{
    public $smsList = [];
    public $name;
    public $url;
    public $parameters = [];
    public $status = 0;
    public $editId = null;
    public $modalVisible = false;
    public $brand;
    public $brands;

    public function mount()
    {
        $this->smsList = Sms::all();
        $this->brands = \App\Models\Brand::whereStatus(true)->get();
    }

    public function saveSms()
    {
        $this->validate([
            'brand' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($this->editId !== null) {
            Sms::find($this->editId)->update([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'url' => $this->url,
                'parameters' => $this->parameters,
                'status' => $this->status,
            ]);
        } else {
            Sms::create([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'url' => $this->url,
                'parameters' => $this->parameters,
                'status' => $this->status,
            ]);
        }
        $this->smsList = Sms::all();
        $this->resetForm();
        $this->hideModal();
    }

    public function deleteSms($id)
    {
        Sms::find($id)?->delete();
        $this->smsList = Sms::all();
    }

    public function editSms($id)
    {
        $sms = Sms::find($id);
        if ($sms) {
            $this->openModal();
            $this->editId = $sms->id;
            $this->brand = $sms->brand_id;
            $this->name = $sms->name;
            $this->url = $sms->url;
            $this->parameters = $sms->parameters;
            $this->status = $sms->status;
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-sms');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->modalVisible = false;
        $this->dispatch('close-modal', 'create-update-sms');
        $this->resetValidation();
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->brand = null;
        $this->name = '';
        $this->url = '';
        $this->parameters = [];
        $this->status = 0;
        $this->editId = null;
    }

    /**
     * Get example JSON for bulk creation (excluding id)
     */
    public static function bulkCreateJsonExample(): array
    {
        return [
            'status' => true,
            'name' => 'string',
            'url' => 'string',
            'parameters' => 'json-string',
        ];
    }

    public function render()
    {
        return view('livewire.sms-component', [
            'sms' => $this->smsList,
        ]);
    }

    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }
}
