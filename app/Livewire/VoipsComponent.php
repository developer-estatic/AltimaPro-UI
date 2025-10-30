<?php

namespace App\Livewire;

use App\Models\Voip;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('VoIPs')]
class VoipsComponent extends Component
{
    public $voipsList = [];
    public $name;
    public $url;
    public $extension;
    public $secretKey;
    public $status = 0;
    public $editId = null;
    public $showModal = false;
    public $brand;
    public $brands;

    public function mount()
    {
        $this->voipsList = Voip::all();
        $this->brands = \App\Models\Brand::whereStatus(true)->get();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->dispatch('open-modal', 'create-update-voip-config');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-voip-config');
        $this->showModal = false;
        $this->resetForm();
    }

    public function saveVoip()
    {
        $this->validate([
            'brand' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'url' => 'required|string|max:255',
            'extension' => 'nullable|string|max:50',
            'secretKey' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($this->editId !== null) {
            Voip::find($this->editId)->update([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'url' => $this->url,
                'extension' => $this->extension,
                'secret_key' => $this->secretKey,
                'status' => $this->status,
            ]);
        } else {
            Voip::create([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'url' => $this->url,
                'extension' => $this->extension,
                'secret_key' => $this->secretKey,
                'status' => $this->status,
            ]);
        }
        $this->voipsList = Voip::all();
        $this->hideModal();
    }

    public function deleteVoip($id)
    {
        Voip::find($id)?->delete();
        $this->voipsList = Voip::all();
    }

    public function editVoip($id)
    {
        $voip = Voip::find($id);
        if ($voip) {
            $this->openModal();
            $this->editId = $voip->id;
            $this->name = $voip->name;
            $this->url = $voip->url;
            $this->extension = $voip->extension;
            $this->secretKey = $voip->secret_key;
            $this->status = $voip->status;
            $this->brand = $voip->brand_id;
        }
    }

    private function resetForm()
    {
        $this->brand = null;
        $this->name = '';
        $this->url = '';
        $this->extension = '';
        $this->secretKey = '';
        $this->status = 0;
        $this->editId = null;
    }

    public function render()
    {
        return view('livewire.voips-component', [
            'voips' => $this->voipsList,
        ]);
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

