<?php

namespace App\Livewire;

use App\Models\Brand;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

#[Layout('layouts.app')]
#[Title('Notifications')]
class NotificationComponent extends Component
{
    use WithFileUploads;
    public $user;
    public $modalVisible = false;
    public $first_name;
    public $last_name;
    public $language;
    public $date_time_format;
    public $phone;
    public $avatar;
    public $email;
    public $default_home_page;


    public function mount()
    {
        $this->user = auth()->user();
        $this->first_name = $this->user->first_name;
        $this->last_name = $this->user->last_name;
        $this->language = $this->user->language;
        $this->date_time_format = $this->user->date_time_format;
        $this->phone = $this->user->phone;
        $this->avatar = $this->user->avatar;
        $this->email = $this->user->email;
        $this->default_home_page = $this->user->default_home_page;

    }

    public function saveDefaultHomePage() {
        $this->user->default_home_page = $this->default_home_page;
        $this->user->save();
        $this->notify('success', 'Default home page updated successfully!');
    }
    public function saveProfile()
    {
        try {
            $rules = [
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'language' => 'required|string|max:255',
                'date_time_format' => 'required|string|max:255',
                'phone' => 'required|unique:users,phone,' . $this->user->id . '|max:20',
            ];

            if ($this->avatar && is_object($this->avatar)) {
                $rules['avatar'] = 'nullable|image|max:2048';
            }

            $this->validate($rules);

            if ($this->avatar && is_object($this->avatar)) {
                $old = $this->user->avatar;
                $this->user->avatar = fileUploader($this->avatar, getFilePath('userProfile'), getFileSize('userProfile'), $old);
            }

            // Update user profile data
            $this->user->first_name = $this->first_name;
            $this->user->last_name = $this->last_name;
            $this->user->language = $this->language;
            $this->user->date_time_format = $this->date_time_format;
            $this->user->phone = $this->phone;
            $this->user->save();
        } catch (\Throwable $th) {
            throw $th;
        }

        // Notify the user
        $this->notify('success', 'Profile updated successfully!');
    }

    public function render()
    {
        return view('livewire.notification-component');
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }

    public function updateUserEmail()
    {
        $this->validate([
            'email' => 'required|email|unique:users,email,' . $this->user->id,
        ]);

        $this->user->email = $this->email;
        $this->user->save();

        $this->notify('success', 'Email updated successfully!');
    }
}
