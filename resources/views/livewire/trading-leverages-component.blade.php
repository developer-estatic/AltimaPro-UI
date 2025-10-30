@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Trading Leverages"></x-partials.header>
</x-slot>
<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-2xl font-bold mb-0">Trading Leverages</h3>
            @if(canPerformAction('settings.trading-leverage.create'))
            <flux:tooltip content="Add Trading Leverage" extra-classes="px-2!">
                <flux:button size="sm" variant="primary" icon="plus" class="cursor-pointer rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-trading-leverage">
            @if ($modalVisible)
            <form wire:submit.prevent="saveTradingLeverage">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Name</flux:label>
                        <flux:description>Enter the name of the trading leverage.</flux:description>
                        <flux:input placeholder="Enter Name" wire:model.defer="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Value</flux:label>
                        <flux:description>Enter the value of the trading leverage.</flux:description>
                        <flux:input placeholder="Enter Value" wire:model.defer="value" />
                        <flux:error name="value" />
                    </flux:field>
                </div>
                <div class="p-4 flex justify-end gap-2">
                    <flux:button wire:click="hideModal" variant="subtle" class="cursor-pointer">Cancel</flux:button>
                    <flux:button variant="primary" type="submit" class="cursor-pointer rounded hover:bg-persian-green">Save</flux:button>
                </div>
            </form>
            @endif
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
            <table class="w-full text-left rtl:text-right text-gray-600">
                <thead class="uppercase bg-gray-300">
                    <tr class="py-8!">
                        <th scope="col" class="px-6 py-3 w-80!">Name</th>
                        <th scope="col" class="px-6 py-3 w-60!">Value</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tradingLeverages as $leverage)
                    <tr class="bg-white border-b border-gray-200" wire:key="user-{{ $leverage->id }}">
                        <td class="px-6 py-2 cursor-pointer">{{ $leverage->name }}</td>
                        <td class="px-6 py-2">{{ $leverage->value }}</td>
                        <td class="px-6 py-2">
                            <div class="d-flex gap-2 text-xs!">
                                <flux:tooltip content="Edit Trading Leverage" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class="cursor-pointer border-1 bg-blue-700/70! text-white! rounded-md!"
                                        wire:click="editTradingLeverage({{ $leverage->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Trading Leverage" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class="cursor-pointer border-1 bg-red-500! text-white! rounded-md!"
                                        wire:click="deleteTradingLeverage({{ $leverage->id }})">
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