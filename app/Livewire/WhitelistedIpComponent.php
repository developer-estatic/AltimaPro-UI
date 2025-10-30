<?php

namespace App\Livewire;

use App\Models\WhitelistedIp;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Whitelisted IPs')]
class WhitelistedIpComponent extends Component
{
    public $ip_address;
    public $showModal = false;
    public $ips = [];
    public $ip_id;
    public $name;
    public $status = 0;
    public $description;
    public $type;
    public $created_dt;
    public $updated_dt;
    public $brand;
    public $brands;

    public function mount()
    {
        $this->ips = WhitelistedIp::all();
        $this->brands = \App\Models\Brand::whereStatus(true)->get();
    }

    public function addWhitelistedIp()
    {
        $this->validate([
            'brand' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'ip_address' => 'required|ip|unique:whitelisted_ips,ip_address,'.$this->ip_id,
            'description' => 'nullable|string',
            'type' => 'nullable|string|max:255',
        ]);

        if($this->ip_id) {
            $this->updateWhitelistedIp();
            $this->notify('success', 'Whitelisted IP Updated successfully.');

        } else {
            WhitelistedIp::create([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'status' => $this->status,
                'ip_address' => $this->ip_address,
                'description' => $this->description,
                'type' => $this->type,
            ]);
            $this->getIps();
            $this->notify('success', 'Whitelisted IP added successfully.');
        }

        $this->hideModal();
    }

    public function editWhitelistedIp($id)
    {
        $ip = WhitelistedIp::find($id);
        if ($ip) {
            $this->openModal();
            $this->ip_id = $ip->id;
            $this->brand = $ip->brand_id;
            $this->name = $ip->name;
            $this->status = $ip->status;
            $this->ip_address = $ip->ip_address;
            $this->description = $ip->description;
            $this->type = $ip->type;
        } else {
            $this->notify('error', 'IP not found.');
        }
    }

    public function updateWhitelistedIp()
    {
        $ip = WhitelistedIp::find($this->ip_id);
        if ($ip) {
            $ip->update([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'status' => $this->status,
                'ip_address' => $this->ip_address,
                'description' => $this->description,
                'type' => $this->type,
            ]);
            $this->getIps();
        } else {
            $this->notify('error', 'IP not found.');
        }
    }

    public function deleteWhitelistedIp($id)
    {
        $ip = WhitelistedIp::find($id);
        if ($ip) {
            $ip->delete();
            $this->getIps();
            $this->notify('success', 'Whitelisted IP deleted successfully.');
        } else {
            $this->notify('error', 'IP not found.');
        }
    }

    public function getIps()
    {
        $this->ips = WhitelistedIp::all();
    }

    public function render()
    {
        return view('livewire.whitelisted-ip-component');
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->dispatch('open-modal', 'create-update-whitelisted-ip');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-whitelisted-ip');
        $this->showModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->ip_id = null;
        $this->ip_address = '';
        $this->name = '';
        $this->status = 0;
        $this->description = '';
        $this->type = '';
        $this->created_dt = null;
        $this->updated_dt = null;
        $this->brand = null;
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

    public function updatedStatus($value)
    {
        $this->status = $value === true ? 1 : 0;
    }
}
