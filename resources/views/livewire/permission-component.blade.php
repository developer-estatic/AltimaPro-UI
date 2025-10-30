@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Permission Configurations"></x-partials.header>
</x-slot>
<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">

        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">Permission Configurations</h3>
            @if(canPerformAction('settings.permissions.create'))
            <flux:tooltip content="Add Permission Configuration" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>


        <x-modal name="create-update-permission">
            @if ($modalVisible)
            <form wire:submit.prevent="savePermission">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Permission Name</flux:label>
                        <flux:description>Enter the name of the permission.</flux:description>
                        <flux:input placeholder="Enter Permission name" wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Display Name</flux:label>
                        <flux:description>Enter the display name for the permission.</flux:description>
                        <flux:input placeholder="Enter Display Name" wire:model="display_name" />
                        <flux:error name="display_name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Module</flux:label>
                        <x-combobox label="" name="module_id" placeholder="Select Module" :options="$modules" :selected="$module_id" :multiple="false" />
                        <flux:error name="module_id" />
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

            <table id="permissions-table" class="w-full text-left rtl:text-right text-gray-600 dataTable table table-bordered table-hover">

                <thead class="uppercase bg-gray-300">
                    <tr class="py-8!">
                        <th scope="col" class="px-6 py-3 w-80!">Name</th>
                        <th scope="col" class="px-6 py-3 w-60!">Display Name</th>
                        <th scope="col" class="px-6 py-3 w-20!">Module</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permissions as $index => $permission)
                    <tr class="bg-white border-b border-gray-200"
                        wire:key="user-{{ $permission->id }}">

                        <td class="px-6 py-2 cursor-pointer">{{ $permission?->name }}</td>
                        <td class="px-6 py-2">{{ $permission?->display_name }}</td>
                        <td class="px-6 py-2">
                            {{ $permission?->module?->name ?? 'N/A' }}
                        </td>
                        <td class="px-6 py-2">
                            <div class="d-flex gap-2 text-xs!">
                                <flux:tooltip content="Edit" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                        wire:click="editPermission({{ $permission->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete" extra-classes="px-2!">
                                    <flux:button variant="outline" square size="sm"
                                        class=" border-1 bg-red-500! text-white! rounded-md!"
                                        wire:click="deletePermission({{ $permission->id }})">
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

{{-- 
    DataTables initialization is now handled globally by resources/js/global-datatable.js
    All tables with class 'table' are automatically initialized with the global config
    No need for table-specific initialization scripts
--}}