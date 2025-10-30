<?php

namespace App\Livewire;

use App\Models\TradingCurrency;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Trading Currencies')]
class TradingCurrenciesComponent extends Component
{
    public $tradingCurrencies = [];
    public $name;
    public $symbol;
    public $status = 0;
    public $editIndex = null;
    public $showModal = false;

    public function mount()
    {
        $this->tradingCurrencies = TradingCurrency::all();
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->dispatch('open-modal', 'create-update-trading-currency');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-trading-currency');
        $this->showModal = false;
        $this->resetForm();
    }

    public function saveTradingCurrency()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'symbol' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($this->editIndex !== null) {
            $currency = $this->tradingCurrencies[$this->editIndex];
            TradingCurrency::find($currency->id)->update([
                'name' => $this->name,
                'symbol' => $this->symbol,
                'status' => $this->status,
            ]);
        } else {
            TradingCurrency::create([
                'name' => $this->name,
                'symbol' => $this->symbol,
                'status' => $this->status,
            ]);
        }
        $this->tradingCurrencies = TradingCurrency::all();
        $this->hideModal();
    }

    public function deleteTradingCurrency($id)
    {
        TradingCurrency::find($id)?->delete();
        $this->tradingCurrencies = TradingCurrency::all();
    }

    public function editTradingCurrency($id)
    {
        $currency = TradingCurrency::find($id);
        if ($currency) {
            $this->showModal = true;
            $this->openModal();
            $this->editIndex = $currency->id;
            $this->name = $currency->name;
            $this->symbol = $currency->symbol;
            $this->status = $currency->status;
        }
    }

    private function resetForm()
    {
        $this->name = '';
        $this->symbol = '';
        $this->status = 0;
        $this->editIndex = null;
    }

    public function render()
    {
        return view('livewire.trading-currencies-component', [
            'tradingCurrencies' => $this->tradingCurrencies,
        ]);
    }
}
