<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\BrandSmtp;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;


#[Layout('layouts.app')]
#[Title('Brand Email Configuration')]
class BrandsSmtp extends Component
{
    public $smtps;
    public $brands;
    public $brand = null;
    public $name = null;
    public $host = null;
    public $username = null;
    public $password = null;
    public $port = null;
    public $encryption = null;
    public $fromEmail = null;
    public $status = 0;
    public $editId = null;
    public $modalVisible = false;

    public function mount()
    {
        $this->smtps = BrandSmtp::get();
        $this->brands = Brand::whereStatus(true)->get();
    }

    public function saveSmtp()
    {
        $this->validate([
            'brand' => 'required|exists:brands,id',
            'name' => 'required|string|max:255',
            'host' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'port' => 'nullable|integer',
            'encryption' => 'nullable|string|max:50',
            'fromEmail' => 'nullable|string|email',
            'status' => 'required|boolean',
        ]);

        if ($this->editId !== null) {
            BrandSmtp::find($this->editId)->update([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'host' => $this->host,
                'username' => $this->username,
                'password' => $this->password,
                'port' => $this->port,
                'encryption' => $this->encryption,
                'from_email' => $this->fromEmail,
                'status' => $this->status,
            ]);
        } else {
            BrandSmtp::create([
                'brand_id' => $this->brand,
                'name' => $this->name,
                'host' => $this->host,
                'username' => $this->username,
                'password' => $this->password,
                'port' => $this->port,
                'encryption' => $this->encryption,
                'from_email' => $this->fromEmail,
                'status' => $this->status,
            ]);
        }
        $this->smtps = BrandSmtp::get();
        $this->hideModal();
        $this->notify('success', 'SMTP configuration saved successfully!');
    }

    public function deleteSmtp($id)
    {
        BrandSmtp::find($id)?->delete();
        $this->smtps = BrandSmtp::get();
        $this->notify('success', 'SMTP configuration deleted successfully!');
    }

    public function openModal()
    {
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-smtp');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->modalVisible = false;
        $this->dispatch('close-modal', 'create-update-smtp');
        $this->resetForm();
    }

    public function editSmtp($id)
    {
        $smtp = BrandSmtp::whereId($id)->firstOrFail();
        if ($smtp) {
            $this->openModal();
            $this->brand = $smtp->brand_id;
            $this->editId = $smtp->id;
            $this->name = $smtp->name;
            $this->host = $smtp->host;
            $this->username = $smtp->username;
            $this->password = $smtp->password;
            $this->port = $smtp->port;
            $this->encryption = $smtp->encryption;
            $this->fromEmail = $smtp->from_email;
            $this->status = $smtp->status;
        }
    }

    private function resetForm()
    {
        $this->brand = null;
        $this->name = null;
        $this->host = null;
        $this->username = null;
        $this->password = null;
        $this->port = null;
        $this->encryption = null;
        $this->fromEmail = null;
        $this->status = 0;
        $this->editId = null;
    }

    public function render()
    {
        return view('livewire.brand-smtp');
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
