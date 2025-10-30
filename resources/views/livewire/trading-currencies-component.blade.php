@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Trading Currencies"></x-partials.header>
</x-slot>
<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">Trading Currencies</h3>
            @if(canPerformAction('settings.trading-currencies.create'))
            <flux:tooltip content="Add Trading Currencies" extra-classes="px-2!">
                <flux:button size="sm" variant="primary" icon="plus" class="rounded-md! cursor-pointer" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-trading-currency">
            @if ($showModal)
            <form wire:submit.prevent="saveTradingCurrency">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Currency Name</flux:label>
                        <flux:description>Enter the name of the currency.</flux:description>
                        <flux:input placeholder="Enter Currency Name" wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Symbol</flux:label>
                        <flux:description>Enter the symbol of the currency.</flux:description>
                        <flux:input placeholder="Enter Currency Symbol" wire:model="symbol" />
                        <flux:error name="symbol" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Status</flux:label>

                        <flux:description>Set the status of the Currency (Active/Inactive).</flux:description>

                        <x-toggle :options="['Inactive', 'Active']" :value="$status"
                            :update="'wire:model.live=status'" />

                        <flux:error name="status" />
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
                    <tr>
                        <th scope="col" class="px-6 py-3 w-80!">Name</th>
                        <th scope="col" class="px-6 py-3">Symbol</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tradingCurrencies as $index => $config)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $config->name }}</td>
                        <td class="px-6 py-4">{{ $config->symbol }}</td>
                        <td class="px-6 py-4">
                            <div class="inline-flex gap-1 items-center">
                                <span class="{{ $config->status ? 'text-green-500' : 'text-red-500' }}">
                                    <i class="fas {{ $config->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                <span>
                                    {{ $config->status ? $activeLabel : $inactiveLabel }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <flux:tooltip content="Edit Trading Currency">
                                    <flux:button variant="outline" square size="sm"
                                        class="border cursor-pointer bg-blue-700/70! text-white! rounded-md"
                                        wire:click="editTradingCurrency({{ $config->id }})">
                                        <i class="fas fa-edit"></i>
                                </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Trading Currency">
                                    <flux:button variant="outline" square size="sm"
                                        class="border cursor-pointer bg-red-500! text-white! rounded-md"
                                        wire:click="deleteTradingCurrency({{ $config->id }})">
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