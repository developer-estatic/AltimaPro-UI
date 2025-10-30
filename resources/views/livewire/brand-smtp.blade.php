@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp
<x-slot name="header">
    <x-partials.header title="SMTP Configurations"></x-partials.header>
</x-slot>

<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">

        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">Email Configuration</h3>
            @if(canPerformAction('settings.brand-email.create'))
            <flux:tooltip content="Add SMTP Configurations" extra-classes="px-2!">
                <flux:button size="sm" variant="primary" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-smtp">
            @if($modalVisible)
            <form wire:submit.prevent="saveSmtp">

                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>Brand</flux:label>
                        <x-combobox label="" name="brand" placeholder="Select Brand" :options="$brands" :selected="$brand" :multiple="false" />
                        <flux:error name="brand" />
                    </flux:field>
                </div>
                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>SMTP Name</flux:label>
                        <flux:input placeholder="Enter SMTP name" wire:model="name" />
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
                        <flux:label>Host</flux:label>
                        <flux:input placeholder="Enter SMTP host" wire:model="host" />
                        <flux:error name="host" />
                    </flux:field>
                </div>

                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>Username</flux:label>
                        <flux:input placeholder="Enter SMTP username" wire:model="username" />
                        <flux:error name="username" />
                    </flux:field>
                </div>

                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>Password</flux:label>
                        <div class="relative" x-data="{ show: false }">
                            <flux:input x-bind:type="show ? 'text' : 'password'" placeholder="Enter SMTP password"
                                wire:model="password" id="smtp-password" />
                            <button type="button" class="absolute inset-y-0 end-0 flex items-center px-2"
                                @click="show = !show">
                                <flux:icon.eye x-show="!show" />
                                <flux:icon.eye-slash x-show="show" />
                            </button>
                        </div>
                        <flux:error name="password" />
                    </flux:field>
                </div>

                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>Port</flux:label>
                        <flux:input type="number" placeholder="Enter SMTP port" wire:model="port" />
                        <flux:error name="port" />
                    </flux:field>
                </div>

                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>Encryption</flux:label>
                        <flux:input placeholder="Enter the encryption type (e.g., SSL/TLS)." wire:model="encryption" />
                        <flux:error name="encryption" />
                    </flux:field>
                </div>

                <div class="px-4 py-3">
                    <flux:field>
                        <flux:label>From Email</flux:label>
                        <flux:input type="email" placeholder="Enter the from / support email address."
                            wire:model="fromEmail" />
                        <flux:error name="fromEmail" />
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
                    <tr class="py-8!">
                        <th scope="col" class="px-6 py-3 w-80!">Brand</th>
                        <th scope="col" class="px-6 py-3 w-60!">Name</th>
                        <th scope="col" class="px-6 py-3">Host</th>
                        <th scope="col" class="px-6 py-3">Username</th>
                        <th scope="col" class="px-6 py-3">Port</th>
                        <th scope="col" class="px-6 py-3">Encryption</th>
                        <th scope="col" class="px-6 py-3">From Email</th>
                        <th scope="col" class="px-6 py-3 w-20!">Status</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($smtps as $smtp)
                    <tr class="bg-white border-b border-gray-200"
                        wire:key="user-{{ $smtp->id }}">

                        <td class="px-6 py-2 cursor-pointer">{{ $smtp?->brand?->name }}</td>
                        <td class="px-6 py-2">{{ $smtp->name }}</td>
                        <td class="px-6 py-2">{{ $smtp->host }}</td>
                        <td class="px-6 py-2">{{ $smtp->username }}</td>
                        <td class="px-6 py-2">{{ $smtp->port }}</td>
                        <td class="px-6 py-2">{{ $smtp->encryption }}</td>
                        <td class="px-6 py-2">{{ $smtp->from_email }}</td>
                        {{-- Status --}}
                        <td class="px-6 py-2 align-middle!">
                            <div class="inline-flex gap-1">
                                <span class="{{ $smtp->status ? 'text-green-500' : 'text-red-500' }}">
                                    <i class="fas {{ $smtp->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                <span class="{{ $smtp->status ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $smtp->status ? $activeLabel : $inactiveLabel }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-2 text-start align-middle">

                            <div class="d-flex gap-2">
                                <flux:tooltip content="Edit SMTP" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                        wire:click="editSmtp({{ $smtp->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete SMTP" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-red-500! text-white! rounded-md!"
                                        wire:click="deleteSmtp({{ $smtp->id }})">
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