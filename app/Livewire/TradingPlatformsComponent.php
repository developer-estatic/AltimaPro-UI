<?php

namespace App\Livewire;

use App\Models\TradingPlatform;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Trading Platforms')]
class TradingPlatformsComponent extends Component
{
    public $tradingPlatforms = [];
    public $name;
    public $status = 0;
    // public $username;
    // public $password;
    public $server;
    public $editId = null;
    public $modalVisible = false;

    public function mount()
    {
        $this->loadTradingPlatforms();
    }

    public function loadTradingPlatforms()
    {
        $this->tradingPlatforms = TradingPlatform::get();
    }

    public function saveTradingPlatform()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            // 'username' => 'required|string|max:255',
            // 'password' => 'required|string|max:255',
            'server' => 'required|string|max:255',
        ]);

        if ($this->editId !== null) {
            $platform = TradingPlatform::find($this->editId);
            if ($platform) {
                $platform->update([
                    'name' => $this->name,
                    'status' => $this->status,
                    // 'username' => $this->username,
                    // 'password' => $this->password,
                    'server' => $this->server,
                ]);
            } else {
                $this->notify('warning', 'Trading Platform not found!');
                $this->hideModal();
                $this->resetForm();
                return;
            }
        } else {
            TradingPlatform::create([
                'name' => $this->name,
                'status' => $this->status,
                // 'username' => $this->username,
                // 'password' => $this->password,
                'server' => $this->server,
            ]);
        }

        $this->loadTradingPlatforms();
        $action = $this->editId !== null ? 'updated' : 'added';
        $this->notify('success', 'Trading Platform ' . $action . ' successfully!');
        $this->hideModal();
        $this->resetForm();
    }

    public function updatedStatus($value)
    {
        $this->status = $value === true ? 1 : 0;
    }

    public function editTradingPlatform($id)
    {
        $this->hideModal();
        $this->openModal();
        $this->modalVisible = true;
        $this->editId = $id;
        $platform = collect($this->tradingPlatforms)->firstWhere('id', $id);
        $this->name = $platform->name;
        $this->status = $platform->status;
        // $this->username = $platform->username;
        // $this->password = $platform->password;
        $this->server = $platform->server;
    }

    public function deleteTradingPlatform($id)
    {
        $platform = TradingPlatform::whereId($id)->first();
        if ($platform) {
            $platform->delete();
            $this->loadTradingPlatforms();
            $this->notify('success', 'Trading Platform deleted successfully!');
        } else {
            $this->notify('warning', 'Trading Platform not found!');
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-trading-platform');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-trading-platform');
        $this->resetForm();
        $this->modalVisible = false;
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->reset(['name', 'status', 'server', 'editId', 'modalVisible']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.trading-platforms-component');
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }
}
