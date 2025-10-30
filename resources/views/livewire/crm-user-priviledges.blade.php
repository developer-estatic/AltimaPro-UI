@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Crm User Priviledges"></x-partials.header>
</x-slot>

<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">
                <span>
                    Crm User Priviledges
                </span>
            </h3>
            @if(canPerformAction('settings.crm-user-privileges.create'))
            <flux:tooltip content="Add Priviledges" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-privilege">
            <form wire:submit.prevent="savePrivilege">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Brand</flux:label>

                        <flux:description>Select a brand.</flux:description>

                        <select wire:model="brand_id" class="form-control">
                            <option value="">-- Select Brand --</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>

                        <flux:error name="brand_id" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>User</flux:label>

                        <flux:description>Select a user.</flux:description>

                        <select wire:model="user_id" class="form-control">
                            <option value="">-- Select User --</option>
                            @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>

                        <flux:error name="user_id" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Privilege</flux:label>

                        <flux:description>Enter the privilege details.</flux:description>

                        <flux:input placeholder="Enter privilege details." wire:model="privilege" />

                        <flux:error name="privilege" />
                    </flux:field>
                </div>

                <div class="p-4 flex justify-end">
                    <flux:button wire:click="hideModal" variant="subtle">Cancel</flux:button>
                    <flux:button variant="primary" type="submit" class="rounded hover:bg-persian-green">Save</flux:button>
                </div>
            </form>
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
            <table class="w-full text-left rtl:text-right text-gray-600">
                <thead class="uppercase bg-gray-300">
                    <tr class="py-8!">
                        <th scope="col" class="px-6 py-3 w-80!">Brand</th>
                        <th scope="col" class="px-6 py-3 w-60!">User</th>
                        <th scope="col" class="px-6 py-3 w-20!">Privilege</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($privileges as $privilege)
                    <tr class="bg-white border-b border-gray-200" wire:key="privilege-{{ $privilege->id }}">
                        <td class="px-6 py-2 cursor-pointer">{{ $privilege->brand->name }}</td>
                        <td class="px-6 py-2">{{ $privilege->user->name }}</td>
                        <td class="px-6 py-2">{{ $privilege->privledge }}</td>
                        <td class="px-6 py-2">
                            <div class="d-flex gap-2 text-xs!">
                                <flux:tooltip content="Edit" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                        wire:click="editPrivilege({{ $privilege->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-red-500! text-white! rounded-md!"
                                        wire:click="deletePrivilege({{ $privilege->id }})">
                                        <i class="fas fa-trash"></i>
                                    </flux:button>
                                </flux:tooltip>
                            </div>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>