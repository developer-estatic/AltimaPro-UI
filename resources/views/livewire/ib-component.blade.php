@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="IB"></x-partials.header>
</x-slot>

<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">
                <span>
                    IB
                </span>
            </h3>
            @if(canPerformAction('settings.ib.create'))
            <flux:tooltip content="Add IB" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>
        <x-modal name="create-update-ib">
            @if ($modalVisible)
            <form wire:submit.prevent="saveIb">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Symbol Master Name</flux:label>
                        <flux:description>Enter the symbol master name.</flux:description>
                        <flux:input placeholder="Enter the symbol master name." wire:model="symbol_master_name" />
                        <flux:error name="symbol_master_name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Symbol Type</flux:label>
                        <flux:description>Enter the symbol type.</flux:description>
                        <x-combobox label="" name="symbol_type" placeholder="Select Symbol Type"
                            :options="$symbol_types" :selected="$symbol_type" :multiple="false" />
                        <flux:error name="symbol_type" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Base Spread Rate</flux:label>
                        <flux:description>Enter the base spread rate.</flux:description>
                        <flux:input type="number" placeholder="Enter the base spread rate."
                            wire:model="base_spread_rate" />
                        <flux:error name="base_spread_rate" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Spread Category</flux:label>
                        <flux:description>Enter the spread category.</flux:description>
                        <x-combobox label="" name="spread_category" placeholder="Select Spread Category"
                            :options="$spread_categories" :selected="$spread_category" :multiple="false" />
                        <flux:error name="spread_category" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Lot Value</flux:label>
                        <flux:description>Enter the lot value.</flux:description>
                        <flux:input type="number" placeholder="Enter the lot value." wire:model="lot_value" />
                        <flux:error name="lot_value" />
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
                    <tr class="py-8!">
                        <th scope="col" class="px-6 py-3 w-80!">Symbol Master Name</th>
                        <th scope="col" class="px-6 py-3 w-60!">Symbol Type</th>
                        <th scope="col" class="px-6 py-3 w-20!">Base Spread Rate</th>
                        <th scope="col" class="px-6 py-3 w-20!">Spread Category</th>
                        <th scope="col" class="px-6 py-3 w-20!">Lot Value</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ibs as $index => $ib)
                    <tr class="bg-white border-b border-gray-200" wire:key="ib-{{ $ib->id }}">
                        <td class="px-6 py-2 cursor-pointer">{{ $ib->symbol_master_name }}</td>
                        <td class="px-6 py-2">{{ $ib->symbolType?->value ?? '' }}</td>
                        <td class="px-6 py-2">{{ $ib->base_spread_rate }}</td>
                        <td class="px-6 py-2">{{ $ib->spreadCategory?->value ?? '' }}</td>
                        <td class="px-6 py-2">{{ $ib->lot_value }}</td>
                        <td class="px-6 py-2">
                            <div class="d-flex gap-2">
                                <flux:tooltip content="Edit SMS" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                        wire:click="editIb({{ $ib->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete SMS" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-red-500! text-white! rounded-md!"
                                        wire:click="deleteIb({{ $ib->id }})">
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