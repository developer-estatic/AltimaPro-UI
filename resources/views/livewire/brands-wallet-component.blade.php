@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp
<x-slot name="header">
    <x-partials.header title="Wallets"></x-partials.header>
</x-slot>

<div>
        <div
            class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">

            <div class="flex justify-between items-center mb-1">
                <h3 class="text-2xl font-bold mb-0">Wallets</h3>
                @if(canPerformAction('settings.brand-wallet.create'))
                <flux:tooltip content="Add Wallet" extra-classes="px-2!">
                    <flux:button size="sm" variant="primary" icon="plus" class="rounded-md!" wire:click="openModal">
                    </flux:button>
                </flux:tooltip>
                @endif
            </div>

            <x-modal name="create-update-wallet">
                <form wire:submit.prevent="saveWallet">
                    <div class="px-4 py-3">
                        <flux:field>
                            <flux:label>Brand</flux:label>
                            <x-combobox label="" name="brand" placeholder="Select Brand" :options="$brands" :selected="$brand" :multiple="false" />
                            <flux:error name="brand" />
                        </flux:field>
                    </div>
                    <div class="px-4 py-3">
                        <flux:field>
                            <flux:label>Wallet Name</flux:label>
                            <flux:input placeholder="Enter name" wire:model="name" />
                            <flux:error name="name" />
                        </flux:field>
                    </div>
                    <div class="px-4 py-3">
                        <flux:field>
                            <flux:label>Status</flux:label>

                            <x-toggle :options="['Inactive', 'Active']" :value="$status"
                                :update="'wire:model.live=status'" />
                            <flux:error name="status" />
                        </flux:field>
                    </div>
                    <div class="px-4 py-3">
                        <flux:field>
                            <flux:label>Type</flux:label>
                            <x-combobox label="" name="type" placeholder="Select Type" :options="$types" :selected="$type" :multiple="false" />
                            <flux:error name="type" />
                        </flux:field>
                    </div>
                    <div class="px-4 py-3">
                        <flux:field>
                            <flux:label>Currency</flux:label>
                            <flux:input placeholder="Enter currency" wire:model="currency" />
                            <flux:error name="currency" />
                        </flux:field>
                    </div>
                    <div class="px-4 py-3">
                        <flux:field>
                            <flux:label>Markup Amount</flux:label>
                            <flux:input type="number" placeholder="Enter markup amount" wire:model="markupAmount" />
                            <flux:error name="markupAmount" />
                        </flux:field>
                    </div>
                    <div class="px-4 py-3">
                        <flux:field>
                            <flux:label>Service Charge</flux:label>
                            <flux:input type="number" placeholder="Enter service charge" wire:model="serviceCharge" />
                            <flux:error name="serviceCharge" />
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
                            <th scope="col" class="px-6 py-3 w-80!">Brand Name</th>
                            <th scope="col" class="px-6 py-3 w-60!">Name</th>
                            <th scope="col" class="px-6 py-3 w-20!">Type</th>
                            <th scope="col" class="px-6 py-3 w-20!">Currency</th>
                            <th scope="col" class="px-6 py-3 w-20!">Markup Amount</th>
                            <th scope="col" class="px-6 py-3 w-20!">Service Charge</th>
                            <th scope="col" class="px-6 py-3 w-20!">Status</th>
                            <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($wallets as $index => $wallet)
                        <tr class="bg-white border-b border-gray-200"
                            wire:key="user-{{ $wallet->id }}">

                            <td class="px-6 py-2 cursor-pointer">{{ $wallet->brand->name }}</td>
                            <td class="px-6 py-2">{{ $wallet->name }}</td>
                            <td class="px-6 py-2">
                                {{ ucwords(getNameFromMetaData($wallet->type)) }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $wallet->currency }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $wallet->markup_amount }}
                            </td>
                            <td class="px-6 py-2">
                                {{ $wallet->service_charge }}
                            </td>
                            <td class="px-6 py-2 align-middle!">
                                <div class="inline-flex gap-1 items-center! text-start align-middle!">
                                    <span class="{{ $wallet->status ? 'text-green-500' : 'text-red-500' }}">
                                        <i
                                            class="fas {{ $wallet->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                    </span>
                                    <span class="{{ $wallet->status ? 'text-green-700' : 'text-red-700' }}">
                                        {{ $wallet->status ? $activeLabel : $inactiveLabel }}
                                    </span>
                                </div>
                            </td>
                            <td class="px-6 py-2">
                                <div class="d-flex gap-2">
                                    <flux:tooltip content="Edit Wallet" extra-classes="px-2!">
                                        <flux:button variant="outline" square size="sm"
                                            class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                            wire:click="editWallet({{ $wallet->id }})">
                                            <i class="fas fa-edit"></i>
                                        </flux:button>
                                    </flux:tooltip>
                                    <flux:tooltip content="Delete Wallet" extra-classes="px-2!">
                                        <flux:button variant="outline" square size="sm"
                                            class=" border-1 bg-red-500! text-white! rounded-md!"
                                            wire:click="deleteWallet({{ $wallet->id }})">
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