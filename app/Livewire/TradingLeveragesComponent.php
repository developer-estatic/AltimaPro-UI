<?php

namespace App\Livewire;

use App\Models\TradingLeverage;
use App\Models\TradingPlatform;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Trading Leverages')]
class TradingLeveragesComponent extends Component
{
    public $tradingLeverages = [];
    public $name;
    public $value;
    public $editIndex = null;
    public $modalVisible = false;

    public function mount()
    {
        $this->tradingLeverages = TradingLeverage::all();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-trading-leverage');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-trading-leverage');
        $this->modalVisible = false;
        $this->resetForm();
    }

    public function saveTradingLeverage()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'value' => 'required|numeric',
        ]);

        $data = [
            'name' => $this->name,
            'value' => $this->value,
        ];

        if ($this->editIndex !== null) {
            TradingLeverage::find($this->editIndex)->update($data);
        } else {
            TradingLeverage::create($data);
        }

        $this->tradingLeverages = TradingLeverage::all();
        $this->hideModal();
        if($this->editIndex !== null) {
            $this->notify('success', 'Trading leverage updated successfully!');
        } else {
            $this->notify('success', 'Trading leverage created successfully!');
        }
    }

    public function deleteTradingLeverage($id)
    {
        TradingLeverage::find($id)?->delete();
        $this->tradingLeverages = TradingLeverage::all();
        $this->notify('success', 'Trading leverage deleted successfully!');
    }

    public function editTradingLeverage($id)
    {
        $leverage = TradingLeverage::find($id);
        if ($leverage) {
            $this->modalVisible = true;
            $this->dispatch('open-modal', 'create-update-trading-leverage');
            $this->editIndex = $leverage->id;
            $this->name = $leverage->name;
            $this->value = $leverage->value;
            $this->modalVisible = true;
        }
    }

    private function resetForm()
    {
        $this->name = '';
        $this->value = '';
        $this->editIndex = null;
    }

    public function render()
    {
        return view('livewire.trading-leverages-component', [
            'tradingLeverages' => $this->tradingLeverages,
        ]);
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }
}
