<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Telegram;

#[Layout('layouts.app')]
#[Title('Telegram')]
class TelegramComponent extends Component
{
    use WithFileUploads;

    public $telegram = [];
    public $name;
    public $logo;
    public $bot_id;
    public $status = 0;
    public $editId = null;
    public $showModal = false;
    public $image;
    public $brand;
    public $brands;

    protected $rules = [
        'name' => 'required|string|max:255',
        'logo' => 'nullable|image|max:2048',
        'bot_id' => 'required|string|max:255',
        'status' => 'required|boolean',
    ];

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
        $this->dispatch('open-modal', 'create-update-telegram-config');
    }

    #[\Livewire\Attributes\On('hideModal')]
    public function hideModal()
    {
        $this->dispatch('close-modal', 'create-update-telegram-config');
        $this->showModal = false;
        $this->resetForm();
    }

    public function saveTelegram()
    {
        $this->validate([
            'brand' => 'nullable|exists:brands,id',
            'name' => 'required|string|max:255',
            'bot_id' => 'required|string|max:255',
            'status' => 'required|boolean',
        ]);

        $logo = $this->image;
        if ($this->logo) {
            $logo = $this->logo->store('telegram-images', 'public');
        }
        $data = [
            'brand_id' => $this->brand,
            'name' => $this->name,
            'image_path' => $logo,
            'bot_id' => $this->bot_id,
            'status' => $this->status,
        ];
        Telegram::updateOrCreate(
            ['id' => $this->editId],
            $data
        );
        if ($this->editId !== null) {
            $this->notify('success', 'Telegram configuration updated successfully!');
        } else {
            $this->notify('success', 'Telegram configuration created successfully!');
        }
        $this->loadTelegramOptions();
        $this->hideModal();
    }

    public function editTelegram($index)
    {
        $telegram = Telegram::whereId($index)->firstOrFail();
        if ($telegram) {
            $this->openModal();
            $this->editId = $telegram->id;
            $this->brand = $telegram->brand_id;
            $this->name = $telegram->name;
            $this->logo = null;
            $this->bot_id = $telegram->bot_id;
            $this->image = $telegram->image_path;
            $this->status = $telegram->status;
        }
    }

    public function deleteTelegram($index)
    {
        Telegram::destroy($this->telegram[$index]['id']);
        $this->notify('success', 'Telegram configuration deleted successfully!');
        $this->loadTelegramOptions();
    }

    private function resetForm()
    {
        $this->brand = null;
        $this->name = '';
        $this->logo = '';
        $this->bot_id = '';
        $this->editId = null;
        $this->image = null;
        $this->status = 0;
    }

    public function render()
    {
        return view('livewire.telegram-component');
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }

    public function loadTelegramOptions()
    {
        $this->telegram = Telegram::get();
    }

    public function mount()
    {
        $this->loadTelegramOptions();
        $this->brands = \App\Models\Brand::whereStatus(true)->get();
    }

    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }
}
