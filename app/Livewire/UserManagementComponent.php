<?php

namespace App\Livewire;

use App\Models\Role;
use App\Models\User;
use App\Models\Country;
use Livewire\Component;
use Illuminate\Support\Arr;
use App\Models\BusinessUnit;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;


#[\Livewire\Attributes\Layout('layouts.app')]
#[\Livewire\Attributes\Title('My Team')]
class UserManagementComponent extends Component
{
    use WithPagination;

    public $users;
    public $businessUnitOptions = [];
    public $business_unit = [];
    public $roles;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $confirm_password;
    public $userRole = null;
    public $editId = null;
    public $modalVisible = false;
    public $countries;
    public $otherUsers;
    public $latest_login;
    public $login_ip;
    public $manager;
    public $address_line_1;
    public $address_line_2;
    public $zipcode;
    public $city;
    public $country;

    public function mount()
    {
        $this->loadData();
    }

    public function loadData()
    {
        $this->users = User::with('roles')->get();
        $this->roles = Role::all(['id', 'name'])->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        })->toArray();
        $this->countries = $this->loadCountries();
        $this->otherUsers = $this->loadOtherUsers();


        $this->loadBusinessUnitOptions();
    }

    public function loadBusinessUnitOptions()
    {
        $this->businessUnitOptions = BusinessUnit::all(['id', 'name'])->map(fn($item) => ['id' => $item->id, 'name' => $item->name])->toArray();
    }

    public function loadOtherUsers()
    {
        $this->otherUsers = User::all(['id', 'first_name', 'last_name'])->toArray();
        return Arr::map($this->otherUsers, function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['first_name'] . ' ' . $item['last_name'],
            ];
        });
    }

    public function loadCountries()
    {
        return Country::all(['id', 'name'])->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
            ];
        })->toArray();
    }

    public function openModal($id = null)
    {
        $this->resetForm();
        if ($id) {
            $user = User::find($id);
            $this->editId = $user->id;
            $this->first_name = $user->first_name;
            $this->last_name = $user->last_name;
            $this->email = $user->email;
            $this->userRole = $user?->roles?->first()?->id ?? null;
            $this->latest_login = $user->latest_login;
            $this->login_ip = $user->login_ip;
            $this->manager = $user->manager_id;
            $this->address_line_1 = $user->address_line_1;
            $this->address_line_2 = $user->address_line_2;
            $this->zipcode = $user->zipcode;
            $this->city = $user->city;
            $this->country = $user->country;
            $this->business_unit = $user->business_unit_id;
            $this->address_line_1 = $user->address_line_1;
            $this->address_line_2 = $user->address_line_2;
            $this->zipcode = $user->zipcode;
            $this->city = $user->city;
            $this->country = $user->country_id;
        }
        $this->modalVisible = true;
        $this->dispatch('open-modal', 'create-update-user');
    }

    #[\Livewire\Attributes\On('hideModal')]
        public function hideModal()
    {
        $this->resetForm();
        $this->dispatch('close-modal', 'create-update-user');
        $this->modalVisible = false;
    }

    public function saveUser()
    {
        $this->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->editId,
            'password' => $this->editId ? 'nullable|min:6' : 'required|min:6',
            'confirm_password' => 'same:password',
            'userRole' => 'required',
            'country' => 'required|exists:countries,id',
            'business_unit' => 'required|exists:business_units,id',
            'manager' => 'nullable|exists:users,id',
            'address_line_1' => 'nullable|string|max:100',
            'address_line_2' => 'nullable|string|max:100',
            'zipcode' => 'nullable|string|max:100',
            'city' => 'nullable|string|max:100',
        ]);

        if ($this->editId) {
            $user = User::find($this->editId);
            $user->fill([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2,
                'zipcode' => $this->zipcode,
                'city' => $this->city,
                'country_id' => $this->country,
                'manager_id' => $this->manager,
                'business_unit_id' => $this->business_unit,

            ]);
            if ($this->password) {
                $user->password = Hash::make($this->password);
            }
            $user->save();
        } else {
            $user = User::create([
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'address_line_1' => $this->address_line_1,
                'address_line_2' => $this->address_line_2,
                'zipcode' => $this->zipcode,
                'city' => $this->city,
                'country_id' => $this->country,
                'manager_id' => $this->manager,
                'business_unit_id' => $this->business_unit,

            ]);
        }

        $user->syncRoles([$this->userRole]);
        $this->notify('success', 'User ' . ($this->editId ? 'updated' : 'created') . ' successfully!');
        $this->hideModal();
        $this->loadData();
    }

    public function deleteUser($id)
    {
        User::find($id)->delete();
        $this->loadData();
        $this->notify('success', 'User deleted successfully');
    }

    public function resetForm()
    {
        $this->first_name = null;
        $this->last_name = null;
        $this->manager = null;
        $this->email = null;
        $this->password = null;
        $this->confirm_password = null;
        $this->userRole = null;
        $this->editId = null;
        $this->country = null;
        $this->otherUsers = null;
        $this->latest_login = null;
        $this->login_ip = null;
        $this->business_unit = null;
        $this->address_line_1 = null;
        $this->address_line_2 = null;
        $this->zipcode = null;
        $this->city = null;
        $this->loadData();
        $this->dispatch('close-modal', 'create-update-user');
        $this->modalVisible = false;
        $this->editId = null;
        $this->resetPage();
        $this->resetErrorBag();
        $this->resetValidation();
    }

    public function render()
    {
        return view('livewire.user-management-component');
    }
    #[\Livewire\Attributes\On('setComboBoxValue')]
    public function setComboBoxValue($value, $field)
    {
        $this->{$field} = $value;
    }

    public function notify($variant, $message)
    {
        $this->dispatch('notify', ['variant'=> $variant, 'message' => $message]);
    }
}
