<x-slot name="header">
    <x-partials.header title="User Management"></x-partials.header>
</x-slot>
<div>
    <div class="flex-1 p-8">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">
                <span>Users / My Team</span>
            </h3>
            @if(canPerformAction('settings.team.create'))
            <flux:tooltip content="Add User" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-user" x-on:close="$wire.dispatchSelf('hideModal', {})">
            @if ($modalVisible)
            <form wire:submit.prevent="saveUser">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Furst Name</flux:label>
                        <flux:input placeholder="Enter your first name" wire:model="first_name" />
                        <flux:error name="first_name" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Last Name</flux:label>
                        <flux:input placeholder="Enter your last name" wire:model="last_name" />
                        <flux:error name="last_name" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Email</flux:label>
                        <flux:input type="email" placeholder="Enter user email" wire:model="email" />
                        <flux:error name="email" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Password</flux:label>
                        <div class="relative" x-data="{ show: false }">
                            <flux:input x-bind:type="show ? 'text' : 'password'" placeholder="Enter password"
                                wire:model="password" id="user-password" />
                            <button type="button" class="absolute inset-y-0 end-0 flex items-center px-2"
                                @click="show = !show">
                                <flux:icon.eye x-show="!show" />
                                <flux:icon.eye-slash x-show="show" />
                            </button>
                        </div>
                        <flux:error name="password" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Confirm Password</flux:label>
                        <div class="relative" x-data="{ show: false }">
                            <flux:input x-bind:type="show ? 'text' : 'password'" placeholder="Confirm password"
                                wire:model="confirm_password" id="user-confirm-password" />
                            <button type="button" class="absolute inset-y-0 end-0 flex items-center px-2"
                                @click="show = !show">
                                <flux:icon.eye x-show="!show" />
                                <flux:icon.eye-slash x-show="show" />
                            </button>
                        </div>
                        <flux:error name="confirm_password" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Business Unit</flux:label>
                        <x-combobox label="" name="business_unit" placeholder="Select Business Unit" :options="$businessUnitOptions"
                            :selected="$business_unit" :multiple="false" />
                        <flux:error name="business_unit" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Role</flux:label>
                        <x-combobox label="" name="userRole" placeholder="Select Role" :options="$roles" :selected="$userRole" :multiple="false" />
                        <flux:error name="userRole" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Manager</flux:label>
                        <x-combobox label="" name="manager" placeholder="Select Manager" :options="$otherUsers"
                            :selected="$manager" :multiple="false" />
                        <flux:error name="manager" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Address Line 1</flux:label>
                        <flux:input placeholder="Enter address line 1" wire:model="address_line_1" />
                        <flux:error name="address_line_1" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Address Line 2</flux:label>
                        <flux:input placeholder="Enter address line 2" wire:model="address_line_2" />
                        <flux:error name="address_line_2" />
                    </flux:field>
                </div>

                <div class="p-4 relative">
                    <flux:field>
                        <flux:label>Country</flux:label>
                        <x-combobox label="" name="country" placeholder="Select Country" :options="$countries"
                            :selected="$country" :multiple="false" />
                        <flux:error name="country" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>City</flux:label>
                        <flux:input placeholder="Enter city" wire:model="city" />
                        <flux:error name="city" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Zipcode</flux:label>
                        <flux:input placeholder="Enter zipcode" wire:model="zipcode" />
                        <flux:error name="zipcode" />
                    </flux:field>
                </div>


                <div class="p-4 mt-4 flex justify-end">
                    <flux:button wire:click="hideModal" variant="subtle">Cancel</flux:button>
                    <flux:button type="submit" variant="primary" class="rounded">Save</flux:button>
                </div>
            </form>
            @endif
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">

            <table class="w-full text-left rtl:text-right text-gray-600">

                <thead class="uppercase bg-gray-300">
                    <tr class="py-8!">
                        <th scope="col" class="px-6 py-3 w-80!">Name</th>
                        <th scope="col" class="px-6 py-3 w-60!">Email</th>
                        <th scope="col" class="px-6 py-3 w-60!">Business Unit</th>
                        <th scope="col" class="px-6 py-3 w-20!">Role</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                    <tr class="bg-white border-b border-gray-200"
                        wire:key="user-{{ $user->id }}">

                        <td class="px-6 py-2 cursor-pointer">{{ $user->name }}</td>
                        <td class="px-6 py-2">{{ $user->email }}</td>
                        <td class="px-6 py-2">{{ $user->businessUnit->name ?? '' }}</td>
                        <td class="px-6 py-2">
                            {{ $user->roles->pluck('name')->join(', ') }}
                        </td>
                        <td class="px-6 py-2">
                            <div class="d-flex gap-2 text-xs!">
                                <flux:tooltip content="Edit" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                        wire:click="openModal({{ $user->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                @if(!isAdmin($user->id))
                                <flux:tooltip content="Delete" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-red-500! text-white! rounded-md!"
                                        wire:click="deleteUser({{ $user->id }})">
                                        <i class="fas fa-trash"></i>
                                    </flux:button>
                                </flux:tooltip>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>