@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Trading Account Types"></x-partials.header>
</x-slot>

<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">
                <span>
                    Trading Account Types
                </span>
            </h3>
            @if(canPerformAction('settings.trading-accounts.create'))
            <flux:tooltip content="Add Trading Account Type" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>
        <x-modal name="create-update-trading-account-type">
            @if ($modalVisible)
            <form wire:submit.prevent="saveTradingAccountType">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Name</flux:label>
                        <flux:description>Enter the name of the trading account type.</flux:description>
                        <flux:input placeholder="Enter the name of the trading account type." wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Value</flux:label>
                        <flux:description>Enter the value of the trading account type.</flux:description>
                        <flux:input placeholder="Enter the value of the trading account type." wire:model="value" />
                        <flux:error name="value" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:description>Set the status of the trading account type (Active/Inactive).
                        </flux:description>
                        <x-toggle :options="['Inactive', 'Active']" :value="$status"
                            :update="'wire:model.live=status'" />
                        <flux:error name="status" />
                    </flux:field>
                </div>

                <div class="p-4 flex justify-end">
                    <flux:button wire:click="hideModal" variant="subtle">Cancel</flux:button>
                    <flux:button variant="primary" type="submit" class="rounded hover:bg-persian-green">Save
                    </flux:button>
                </div>
            </form>
            @endif
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
            <table class="w-full text-left rtl:text-right text-gray-600">
                <thead class="uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Value</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tradingAccountTypes as $index => $type)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $type->name }}</td>
                        <td class="px-6 py-4">{{ $type->value }}</td>
                        <td class="px-6 py-4">
                            <div class="inline-flex gap-1 items-center">
                                <span class="{{ $type->status ? 'text-green-500' : 'text-red-500' }}">
                                    <i class="fas {{ $type->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                <span class="{{ $type->status ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $type->status ? $activeLabel : $inactiveLabel }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <flux:tooltip content="Edit Trading Account Type">
                                    <flux:button variant="outline" square size="sm"
                                        class="border bg-blue-700 text-white rounded-md"
                                        wire:click="editTradingAccountType({{ $type->id }})">
                                        <i class="fas fa-edit"></i>
                                </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Trading Account Type">
                                    <flux:button variant="outline" square size="sm"
                                        class="border bg-red-500 text-white rounded-md"
                                        wire:click="deleteTradingAccountType({{ $type->id }})">
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