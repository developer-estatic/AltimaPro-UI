<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
#[Title('Brands')]
class BrandsComponent extends Component
{
    public $brands = [];
    public $name;
    public $status = 0;
    public $editId = null;
    public $details;

    public $modalVisible = false;

    public function mount()
    {
        $this->loadBrands();
    }

    public function loadBrands()
    {
        $this->brands = Brand::get();
        $this->dispatch('reload-datatable');
    }


    public function saveBrand()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        if ($this->editId !== null) {
            $brand = Brand::find($this->editId);
            if ($brand) {
                $brand->update([
                    'name' => $this->name,
                    'status' => $this->status,
                ]);
            } else {
                $this->notify('warning', 'Brand not found!');
                $this->hideModal();
                $this->resetForm();
                return;
            }
        } else {
            $brand = Brand::create([
                'name' => $this->name,
                'status' => $this->status,
            ]);
        }

        $this->loadBrands();
        $action = $this->editId !== null ? 'updated' : 'added';
        $this->notify('success', 'Brand ' . $action . ' successfully!');
        $this->hideModal();
        $this->resetForm();
    }

    public function updatedStatus($value)
    {
        $this->status = $value === true ? 1 : 0;
    }

    public function editBrand($id)
    {
        $this->hideModal();
        $this->openModal();
        $this->modalVisible = true;
        $this->editId = $id;
        $brand = collect($this->brands)->firstWhere('id', $id);
        $this->name = $brand->name;
        $this->status = $brand->status;
    }

    public function deleteBrand($id)
    {
        $id =100;
        $brand = Brand::whereId($id)->first();
        if ($brand) {
            $brand->delete();
            $this->loadBrands();
            $this->notify('success', 'Brand deleted successfully!');
        } else {
            $this->notify('warning', 'Brand not found!');
        }
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-brand');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-brand');
        $this->resetForm();
        $this->modalVisible = false;
    }

    private function resetForm()
    {
        $this->editId = null;
        $this->reset(['name', 'status', 'editId', 'modalVisible']);
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.brands-component');
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }

    public function showDetails($brandId, $type)
    {
        $brand = collect($this->brands)->firstWhere('id', $brandId);
        switch($type) {
            case 'business_units':
                $this->details = view('livewire.brands-component.business-unit-details', [
                    'business_units' => $brand->businessUnits ?? [],
                    'brand_id' => $brandId,
                    'title' => 'Business Unit Details for Brand: ' . $brand->name,
                ])->render();
                $this->dispatch('open-modal', 'show-details-modal');
                break;
            case 'smtp':
                $this->details = view('livewire.brands-component.smtp-details', [
                    'smtpDetails' => $brand->smtp ?? [],
                    'brand_id' => $brandId,
                    'title' => 'SMTP Details for Brand: ' . $brand->name,
                ])->render();
                $this->dispatch('open-modal', 'show-details-modal');
                break;
            case 'sms':
                $this->details = view('livewire.brands-component.sms-details', [
                    'smsDetails' => $brand->sms ?? [],
                    'brand_id' => $brandId,
                    'title' => 'SMS Details for Brand: ' . $brand->name,
                ])->render();
                $this->dispatch('open-modal', 'show-details-modal');
                break;
            case 'telegram':
                $this->details = view('livewire.brands-component.telegram-details', [
                    'telegramDetails' => $brand->telegram ?? [],
                    'brand_id' => $brandId,
                    'title' => 'Telegram Details for Brand: ' . $brand->name,
                ])->render();
                $this->dispatch('open-modal', 'show-details-modal');
                break;
            case 'voips':
                $this->details = view('livewire.brands-component.voip-details', [
                    'voipDetails' => $brand->voips ?? [],
                    'brand_id' => $brandId,
                    'title' => 'VoIP Details for Brand: ' . $brand->name,
                ])->render();
                $this->dispatch('open-modal', 'show-details-modal');
                break;
            case 'wallets':
                $this->details = view('livewire.brands-component.wallet-details', [
                    'walletDetails' => $brand->wallets ?? [],
                    'brand_id' => $brandId,
                    'title' => 'Wallets for Brand: ' . $brand->name,
                ])->render();
                $this->dispatch('open-modal', 'show-details-modal');
                break;
            case 'whitelisted_country':
                $this->details = view('livewire.brands-component.whitelisted-country-details', [
                    'whitelistedCountries' => $brand->whitelistedCountries ?? [],
                    'brand_id' => $brandId,
                    'title' => 'Whitelisted Countries for Brand: ' . $brand->name,
                ])->render();
                $this->dispatch('open-modal', 'show-details-modal');
                break;
            case 'whitelisted_ip':
                $this->details = view('livewire.brands-component.whitelisted-ip-details', [
                    'whitelistedIps' => $brand->whitelistedIps ?? [],
                    'brand_id' => $brandId,
                    'title' => 'Whitelisted IPs for Brand: ' . $brand->name,
                ])->render();
                $this->dispatch('open-modal', 'show-details-modal');
                break;
            default:
                $this->notify('warning', 'Invalid type selected!');
                break;
        }
    }
}
