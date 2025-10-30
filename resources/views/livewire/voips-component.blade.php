@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="VoIP Configurations"></x-partials.header>
</x-slot>
<div>

    {{-- <div class="md:flex px-4 relative">
        <x-settings-sidebar /> --}}
        <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
            <div class="flex justify-between items-center mb-1">
                <h3 class="text-2xl font-bold mb-0">VoIP Configurations</h3>
                @if(canPerformAction('settings.voips.create'))
                <flux:tooltip content="Add VoIP Configuration" extra-classes="px-2!">
                    <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                    </flux:button>
                </flux:tooltip>
                @endif
            </div>


            <x-modal name="create-update-voip-config">
                @if ($showModal)
                <form wire:submit.prevent="saveVoip">
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Brand</flux:label>
                            <x-combobox label="" name="brand" placeholder="Select Brand" :options="$brands" :selected="$brand" :multiple="false" />
                            <flux:error name="brand" />
                        </flux:field>
                    </div>
                    <div class="p-4">
                        <flux:field>
                            <flux:label>VoIP Name</flux:label>
                            <flux:description>Enter the name of the VoIP configuration.</flux:description>
                            <flux:input placeholder="VoIP Name" wire:model="name" />
                            <flux:error name="name" />
                        </flux:field>
                    </div>

                    <div class="p-4">
                        <flux:field>
                            <flux:label>URL</flux:label>
                            <flux:description>Enter the URL for the VoIP configuration.</flux:description>
                            <flux:input placeholder="Enter URL" wire:model="url" />
                            <flux:error name="url" />
                        </flux:field>
                    </div>

                    <div class="p-4">
                        <flux:field>
                            <flux:label>Extension</flux:label>
                            <flux:description>Enter the extension for the VoIP configuration.</flux:description>
                            <flux:input placeholder="Enter extension" wire:model="extension" />
                            <flux:error name="extension" />
                        </flux:field>
                    </div>

                    <div class="p-4">
                        <flux:field>
                            <flux:label>Secret Key</flux:label>
                            <flux:description>Enter the secret key for the VoIP configuration.</flux:description>
                            <flux:input placeholder="Enter secret key" wire:model="secretKey" />
                            <flux:error name="secretKey" />
                        </flux:field>
                    </div>

                    <div class="p-4">
                        <flux:field>
                            <flux:label>Status</flux:label>
                            <flux:description>Set the status of the VoIP configuration.</flux:description>
                            <x-toggle :options="['Inactive', 'Active']" :value="$status"
                                :update="'wire:model.live=status'" />
                            <flux:error name="status" />
                        </flux:field>
                    </div>

                    <div class="p-4 flex justify-end">
                        <flux:button wire:click="hideModal" variant="subtle">Cancel</flux:button>
                        <flux:button variant="primary" type="submit" class="rounded">Save</flux:button>
                    </div>
                </form>
                @endif
            </x-modal>

            <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
                <table class="w-full text-left rtl:text-right text-gray-600">
                    <thead class="uppercase bg-gray-300">
                        <tr>
                            <th scope="col" class="px-6 py-3 w-80!">Brand Name</th>
                            <th scope="col" class="px-6 py-3 w-80!">Name</th>
                            <th scope="col" class="px-6 py-3">URL</th>
                            <th scope="col" class="px-6 py-3">Extension</th>
                            <th scope="col" class="px-6 py-3">Secret Key</th>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="w-40! px-6 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($voips as $index => $config)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4">{{ $config?->brand?->name }}</td>
                            <td class="px-6 py-4">{{ $config?->name }}</td>
                            <td class="px-6 py-4">{{ $config?->url }}</td>
                            <td class="px-6 py-4">{{ $config?->extension }}</td>
                            <td class="px-6 py-4">{{ $config?->secret_key }}</td>
                            <td class="px-6 py-4">
                                <div class="inline-flex gap-1 items-center">
                                    <span class="{{ $config?->status ? 'text-green-500' : 'text-red-500' }}">
                                        <i class="fas {{ $config?->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                    </span>
                                    <span>
                                        {{ $config?->status ? $activeLabel : $inactiveLabel }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <flux:tooltip content="Edit">
                                        <flux:button variant="outline" square size="sm" class="border bg-blue-700/70! text-white! rounded-md" wire:click="editVoip({{ $config?->id }})">
                                            <i class="fas fa-edit"></i>
                                        </flux:button>
                                    </flux:tooltip>
                                    <flux:tooltip content="Delete">
                                        <flux:button variant="outline" square size="sm" class="border bg-red-500! text-white! rounded-md" wire:click="deleteVoip({{ $config?->id }})">
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
        {{--
    </div> --}}
</div>