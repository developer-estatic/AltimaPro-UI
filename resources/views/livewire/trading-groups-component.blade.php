@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Trading Groups"></x-partials.header>
</x-slot>
<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">Trading Groups</h3>
            @if(canPerformAction('settings.trading-groups.create'))
            <flux:tooltip content="Add Trading Group" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-trading-group">
            <form wire:submit.prevent="saveTradingGroup">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Name</flux:label>
                        <flux:description>Enter the name of the trading group.</flux:description>
                        <flux:input placeholder="Enter the name of the trading group." wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:description>Set the status of the trading group (Active/Inactive).</flux:description>
                        <x-toggle :options="['Inactive', 'Active']" :value="$status"
                            :update="'wire:model.live=status'" />
                        <flux:error name="status" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Account Type</flux:label>
                        <flux:description>Select the account type.</flux:description>
                        <x-combobox label="" name="trading_account_type_id" placeholder="Select Account Type" :options="$tradingAccountTypeOptions" :selected="$trading_account_type_id" :multiple="false" />
                        <flux:error name="trading_account_type_id" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Trading Currency</flux:label>
                        <flux:description>Select the trading currency.</flux:description>
                        <x-combobox label="" name="trading_currency_id" placeholder="Select Trading Currency" :options="$tradingCurrencyOptions" :selected="$trading_currency_id" :multiple="false" />
                        <flux:error name="trading_currency_id" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Business Unit</flux:label>
                        <flux:description>Select the business unit.</flux:description>
                        <x-combobox label="" name="business_unit_id" placeholder="Select Business Unit" :options="$businessUnitOptions"
                            :selected="$business_unit_id" :multiple="false" />
                        <flux:error name="business_unit_id" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Trading Platform</flux:label>
                        <flux:description>Select the trading platform.</flux:description>
                        <x-combobox label="" name="trading_platform_id"
                            placeholder="Select Trading Platform" :options="$tradingPlatformOptions"
                            :selected="$trading_platform_id" :multiple="false" />
                        <flux:error name="trading_platform_id" />
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
                    <tr>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 w-40!">Name</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Account Type</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Trading Currency</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Business Unit</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Trading Platform</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3">Status</th>
                        <th scope="col" class="whitespace-nowrap px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tradingGroups as $index => $group)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="whitespace-nowrap px-6 py-4">{{ $group->name }}</td>

                        <td class="whitespace-nowrap px-6 py-4">{{ $group->tradingAccountType->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $group->tradingCurrency->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $group->businessUnit->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4">{{ $group->tradingPlatform->name }}</td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="inline-flex gap-1">
                                <span class="{{ $group->status ? 'text-green-500' : 'text-red-500' }}">
                                    <i class="fas {{ $group->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                <span class="{{ $group->status ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $group->status ? $activeLabel : $inactiveLabel }}
                                </span>
                            </div>
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            <div class="flex gap-2">
                                <flux:tooltip content="Edit Trading Group">
                                    <flux:button variant="outline" square size="sm" class="border bg-blue-700/70! text-white! rounded-md" wire:click="editTradingGroup({{ $group->id }})">
                                        <i class="fas fa-edit"></i>
                                </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Trading Group">
                                    <flux:button variant="outline" square size="sm" class="border bg-red-500! text-white! rounded-md" wire:click="deleteTradingGroup({{ $group->id }})">
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