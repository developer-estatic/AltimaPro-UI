@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp
<x-slot name="header">
    <x-partials.header title="Whitelisted Countries"></x-partials.header>
</x-slot>

<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">

        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">Whitelisted Countries</h3>
            @if(canPerformAction('settings.whitelisted-countries.create'))
            <flux:tooltip content="Add Country" extra-classes="px-2!">
                <flux:button size="sm" variant="primary" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-whitelisted-country">
            <form wire:submit.prevent="saveWhitelistedCountry">
                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>Brand</flux:label>
                        <x-combobox label="" name="brand" placeholder="Select Brand" :options="$brands" :selected="$brand" :multiple="false" />
                        <flux:error name="brand" />
                    </flux:field>
                </div>
                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>Countries</flux:label>
                        <x-combobox label="" name="countries" placeholder="Select Countries" :options="$countriesList" :selected="$countries" :multiple="true" />
                        <flux:error name="countries" />
                    </flux:field>
                </div>
                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>Name</flux:label>
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
                <div class="p-4 flex justify-end">
                    <flux:button wire:click="hideModal" variant="subtle">Cancel</flux:button>
                <flux:button variant="primary" type="submit" class="rounded ">Save</flux:button>
                </div>
            </form>
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">

            <table class="w-full text-left rtl:text-right text-gray-600">

                <thead class="uppercase bg-gray-300">
                    <tr class="py-8!">
                        <th scope="col" class="px-6 py-3 w-80!">Brand Name</th>
                        <th scope="col" class="px-6 py-3 w-60!">Country Name</th>
                        <th scope="col" class="px-6 py-3 w-40!">Name</th>
                        <th scope="col" class="px-6 py-3 w-20!">Status</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($whitelistedCountries as $index => $country)
                    <tr class="bg-white border-b border-gray-200"
                        wire:key="user-{{ $country->id }}">

                        <td class="px-6 py-2 cursor-pointer">{{ $country?->brand?->name }}
                        </td>
                        <td class="px-6 py-2">{{
                            getCountryNames($country->countries) }}</td>
                        <td class="px-6 py-2">{{ $country->name }}</td>
                        <td class="px-6 py-2 align-middle!">
                            <div class="inline-flex gap-1 items-center! text-start align-middle!">
                                <span class="{{ $country->status ? 'text-green-500' : 'text-red-500' }}">
                                    <i class="fas {{ $country->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                <span class="{{ $country->status ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $country->status ? $activeLabel : $inactiveLabel }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-2">

                            <div class="d-flex gap-2">
                                <flux:tooltip content="Edit Whitelisted Country" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                        wire:click="editWhitelistedCountry({{ $country->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Whitelisted Country" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-red-500! text-white! rounded-md!"
                                        wire:click="deleteWhitelistedCountry({{ $country->id }})">
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