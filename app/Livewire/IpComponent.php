<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\WhitelistedIp;

class IpComponent extends Component
{
    public $ip_address;

    public function addWhitelistedIp()
    {
        $this->validate([
            'ip_address' => 'required|ip',
        ]);

        WhitelistedIp::create(['ip_address' => $this->ip_address]);

        session()->flash('message', 'Whitelisted IP Address added successfully.');
        $this->reset('ip_address');
    }

    public function render()
    {
        return view('livewire.whitelisted-ip-component', [
            'whitelistedIps' => WhitelistedIp::all(),
        ]);
    }
}
