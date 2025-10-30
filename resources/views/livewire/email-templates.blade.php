@php
    $activeLabel = __('Active');
    $inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Email Templates"></x-partials.header>
</x-slot>
<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">Email Templates</h3>
            @if(canPerformAction('settings.email-templates.create'))
            <flux:tooltip content="Add Email Template" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>

        <x-modal name="create-update-email-template">
            @if ($showModal)
                <form wire:submit.prevent="store">
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Business Unit</flux:label>
                            <x-combobox label="" name="business_unit_id" placeholder="Select Business Unit"
                                :options="$businessUnits" :selected="$business_unit_id" :multiple="false" wire:model="business_unit_id" />
                            <flux:error name="business_unit_id" />
                        </flux:field>
                    </div>
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Name</flux:label>
                            <flux:input placeholder="Template Name" wire:model="name" />
                            <flux:error name="name" />
                        </flux:field>
                    </div>
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Status</flux:label>
                            <x-toggle :options="['Inactive', 'Active']" :value="$status" :update="'wire:model.live=status'" />
                            <flux:error name="status" />
                        </flux:field>
                    </div>
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Type</flux:label>
                            <x-combobox label="" name="type_id" placeholder="Select Type" :options="$types"
                                :selected="$type_id" :multiple="false" wire:model="type_id" />
                            <flux:error name="type_id" />
                        </flux:field>
                    </div>
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Language</flux:label>
                            <flux:input placeholder="Enter Language" wire:model="language" />
                            <flux:error name="language" />
                        </flux:field>
                    </div>
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Subject</flux:label>
                            <flux:input placeholder="Enter Subject" wire:model="subject" />
                            <flux:error name="subject" />
                        </flux:field>
                    </div>
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Body</flux:label>
                            <flux:textarea placeholder="Enter Body" wire:model="body" />
                            <flux:error name="body" />
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
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3">Type</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($emailTemplates as $template)
                        <tr class="bg-white border-b border-gray-200" wire:key="template-{{ $template->id }}">
                            <td class="px-6 py-2 cursor-pointer">{{ $template->name }}</td>
                            <td class="px-6 py-2">
                                <span class="{{ $template->status ? 'text-green-500' : 'text-red-500' }}">
                                    <i class="fas {{ $template->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                {{ $template->status ? $activeLabel : $inactiveLabel }}
                            </td>
                            <td class="px-6 py-2">{{ $template->type->name ?? 'N/A' }}</td>
                            <td class="px-6 py-2">
                                <div class="d-flex gap-2 text-xs!">
                                    <flux:tooltip content="Edit" extra-classes="px-2!">
                                        <flux:button variant="outline" square size="sm"
                                            class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                            wire:click="edit({{ $template->id }})">
                                            <i class="fas fa-edit"></i>
                                        </flux:button>
                                    </flux:tooltip>
                                    <flux:tooltip content="Delete" extra-classes="px-2!">
                                        <flux:button variant="outline" square size="sm"
                                            class=" border-1 bg-red-500! text-white! rounded-md!"
                                            wire:click="delete({{ $template->id }})">
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
