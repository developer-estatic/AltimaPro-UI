<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\BrandWallet;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Brand Wallet')]
class BrandsWalletComponent extends Component
{
    public $wallets = [];
    public $brands = [];
    public $brand = null;
    public $name = null;
    public $status = 0;
    public $type = null;
    public $walletName = null;
    public $walletStatus = null;
    public $walletType = null;
    public $currency = null;
    public $markupAmount = null;
    public $serviceCharge = null;
    public $editId = null;
    public $modalVisible = false;
    public $types = [];

    public function mount()
    {
        $this->wallets = BrandWallet::get();
        $this->brands = Brand::whereStatus(true)->get();
        $this->types = getTypesFromCRMMetaData('wallet_type');

    }

    public function saveWallet()
    {
        $this->validate([
            'brand' => 'required|exists:brands,id',
            'name' => 'required|string|max:100',
            'status' => 'required|boolean',
            'type' => 'nullable|regex:/^[a-z0-9\s]*$/i',
            'currency' => 'nullable|string|max:100',
            'markupAmount' => 'nullable|numeric',
            'serviceCharge' => 'nullable|numeric',
        ]);

        if ($this->editId !== null) {
            BrandWallet::find($this->editId)->update([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'status' => $this->status,
                'type' => $this->type,
                'currency' => $this->currency,
                'markup_amount' => $this->markupAmount,
                'service_charge' => $this->serviceCharge,
            ]);
        } else {
            BrandWallet::create([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'status' => $this->status,
                'type' => $this->type,
                'currency' => $this->currency,
                'markup_amount' => $this->markupAmount,
                'service_charge' => $this->serviceCharge,
            ]);
        }
        $this->wallets = BrandWallet::all();
        $this->hideModal();
        $this->notify('success', 'Wallet saved successfully!');
    }

    public function deleteWallet($id)
    {
        BrandWallet::find($id)?->delete();
        $this->wallets = BrandWallet::get();
        $this->notify('success', 'Wallet deleted successfully!');
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-wallet');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->modalVisible = false;
        $this->dispatch('close-modal', 'create-update-wallet');
        $this->resetForm();
    }

    public function editWallet($id)
    {
        $this->hideModal();
        $wallets = BrandWallet::whereId($id)->firstOrFail();
        if ($wallets) {
            $this->editId = $wallets->id;
            $this->name = $wallets->name;
            $this->status = $wallets->status;
            $this->type = $wallets->type;
            $this->currency = $wallets->currency;
            $this->markupAmount = $wallets->markup_amount;
            $this->serviceCharge = $wallets->service_charge;
            $this->openModal();
        }
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->name = null;
        $this->status = 0;
        $this->type = null;
        $this->currency = null;
        $this->markupAmount = null;
        $this->serviceCharge = null;
    }

    public function render()
    {
        return view('livewire.brands-wallet-component');
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
