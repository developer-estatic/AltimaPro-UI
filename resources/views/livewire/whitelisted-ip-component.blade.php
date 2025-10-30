@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Whitelist IPs"></x-partials.header>
</x-slot>
<div>

    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">Whitelist IPs</h3>
            @if(canPerformAction('settings.whitelisted-ips.create'))
            <flux:tooltip content="Add Whitelisted IP" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>


        <x-modal name="create-update-whitelisted-ip">
            @if ($showModal)
            <form wire:submit.prevent="addWhitelistedIp">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Brand</flux:label>
                        <x-combobox label="" name="brand" placeholder="Select Brand" :options="$brands" :selected="$brand" :multiple="false" />
                        <flux:error name="brand" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Name</flux:label>
                        <flux:input placeholder="Enter name" wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <x-toggle :options="['Inactive', 'Active']" :value="$status"
                            :update="'wire:model.live=status'" />
                        <flux:error name="status" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Ip Address</flux:label>
                        <flux:input placeholder="Enter IP address" wire:model="ip_address" />
                        <flux:error name="ip_address" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Type</flux:label>
                        <flux:input placeholder="Enter type" wire:model="type" />
                        <flux:error name="type" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Description</flux:label>
                        <flux:textarea placeholder="Enter description" wire:model="description"></flux:textarea>
                        <flux:error name="description" />
                    </flux:field>
                </div>



                <div class="p-4 flex justify-end">
                    <flux:button wire:click="hideModal" variant="subtle">Cancel</flux:button>
                    <flux:button variant="primary" type="submit" class="rounded hover:bg-persian-green">Save</flux:button>
                </div>
            </form>
            @endif
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
            <table class="w-full text-left rtl:text-right text-gray-600">
                <thead class="uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="px-6 whitespace-nowrap py-3 w-60!">Name</th>
                        <th scope="col" class="px-6 whitespace-nowrap py-3 w-40!">Brand</th>
                        <th scope="col" class="px-6 whitespace-nowrap py-3">IP Address</th>
                        <th scope="col" class="px-6 whitespace-nowrap py-3">Type</th>
                        <th scope="col" class="px-6 whitespace-nowrap py-3">Description</th>
                        <th scope="col" class="px-6 whitespace-nowrap py-3">Status</th>
                        <th scope="col" class="px-6 whitespace-nowrap py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ips as $ip)
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $ip->name }}</td>
                        <td class="px-6 py-4">{{ $ip->brand->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4">{{ $ip->ip_address }}</td>
                        <td class="px-6 py-4">{{ $ip->type }}</td>
                        <td class="px-6 py-4">
                            @if(strlen($ip->description) > 30)
                            <flux:tooltip content="{{ $ip->description }}" extra-classes="p-4! font-light! text-md!">
                                <span class="cursor-pointer">
                                    {{ \Illuminate\Support\Str::limit($ip->description, 30, '...') }}
                                </span>
                            </flux:tooltip>
                            @else
                            {{ $ip->description }}
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <div class="inline-flex gap-1">
                                <span class="{{ $ip->status ? 'text-green-500!' : 'text-red-500!' }}">
                                    <i class="fas {{ $ip->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                <span class="{{ $ip->status ? 'text-green-700!' : 'text-red-700!' }}">
                                    {{ $ip->status ? 'Active' : 'Inactive' }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <flux:tooltip content="Edit Whitelisted IP">
                                    <flux:button variant="outline" square size="sm" class="border bg-blue-700/70! text-white! rounded-md"
                                        wire:click="editWhitelistedIp({{ $ip->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Whitelisted IP">
                                    <flux:button variant="outline" square size="sm" class="border bg-red-500! text-white! rounded-md"
                                        wire:click="deleteWhitelistedIp({{ $ip->id }})">
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