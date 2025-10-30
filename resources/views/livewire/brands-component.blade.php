@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Brands"></x-partials.header>
</x-slot>

<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">
                <span>
                    Brands
                </span>
            </h3>
            @if(canPerformAction('settings.brands.create'))
            <flux:tooltip content="Add Brand" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>
        <x-modal name="create-update-brand">
            @if ($modalVisible)
            <form wire:submit.prevent="saveBrand">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Brand Name</flux:label>
                        <flux:description>Enter the name of the brand.</flux:description>
                        <flux:input placeholder="Enter the name of the brand." wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:description>Set the status of the brand (Active/Inactive).</flux:description>
                        <x-toggle :options="['Inactive', 'Active']" :value="$status"
                            :update="'wire:model.live=status'" />
                        <flux:error name="status" />
                    </flux:field>
                </div>

                <div class="p-4 flex justify-end">
                    <flux:button class="cursor-pointer" wire:click="hideModal" variant="subtle">Cancel</flux:button>
                    @if(($editId && canPerformAction('settings.brands.update')) || (!$editId && canPerformAction('settings.brands.store')))
                        <flux:button variant="primary" type="submit" class="rounded hover:bg-persian-green cursor-pointer">{{ $editId ? 'Update' : 'Save' }}</flux:button>
                    @endif
                </div>
            </form>
            @endif
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
            <table class="w-full text-left rtl:text-right text-gray-600" id="brands-datatable">
                <thead class="uppercase bg-gray-300">
                    <tr class="py-8!">
                        <th scope="col" class="px-6 py-3 w-40!">Name</th>
                        <th scope="col" class="px-6 py-3 w-60!">Details</th>
                        <th scope="col" class="px-6 py-3 w-20!">Status</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($brands as $index => $brand)
                    <tr class="bg-white border-b border-gray-200" wire:key="brand-{{ $brand->id }}">
                        <td class="px-6 py-2 cursor-pointer text-start align-middle! whitespace-pre-wrap">{{ $brand->name }}
                        </td>
                        <td class="px-6 py-2 text-start align-middle!">
                            <div class="flex flex-wrap gap-2">
                                <a class="hover:text-blue-700" href="{{ route('settings.business-units.index') }}">Business Units</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.brand-email.index') }}">SMTP</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.sms.index') }}">SMS</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.telegram.index') }}">Telegram</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.voips.index') }}">VoIPs</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.brand-wallet.index') }}">Wallet</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.whitelisted-ips.index') }}">Whitelisted IPs</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.whitelisted-countries.index') }}">Whitelisted Countries</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.trading-groups.index') }}">Trading Groups</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.trading-currencies.index') }}">Trading Currencies</a>
                                <div>|</div>
                                <a class="hover:text-blue-700" href="{{ route('settings.trading-platforms.index') }}">Trading Platforms</a>
                            </div>
                        </td>

                        <td class="px-6 py-2 align-middle!">
                            <div class="inline-flex gap-1 items-center! text-start align-middle!">
                                <span class="{{ $brand->status ? 'text-green-500' : 'text-red-500' }}">
                                    <i class="fas {{ $brand->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                <span class="{{ $brand->status ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $brand->status ? $activeLabel : $inactiveLabel }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-2 text-start align-middle!">
                            <div class="d-flex gap-2 text-xs!">
                                @if(canPerformAction('settings.brands.edit'))
                                <flux:tooltip content="Edit" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class="cursor-pointer border-1 bg-blue-700/70! text-white! rounded-md!"
                                        wire:click="editBrand({{ $brand->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                @endif
                                @if(canPerformAction('settings.brands.destroy'))
                                <flux:tooltip content="Delete" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class="cursor-pointer border-1 bg-red-500! text-white! rounded-md!"
                                        wire:click="deleteBrand({{ $brand->id }})"     wire:confirm="Are you sure you want to delete this this brand?">
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
    <x-modal name="show-details-modal">
        <div class="p-3">
            {!! $details !!}
        </div>
    </x-modal>
</div>