@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Telegram Configurations"></x-partials.header>
</x-slot>
<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            @if(canPerformAction('settings.telegram.create'))
            <h3 class="text-2xl font-bold mb-0">Telegram Configurations</h3>
            <flux:tooltip content="Add Telegram Configuration" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal"></flux:button>
            </flux:tooltip>
            @endif
        </div>


        <x-modal name="create-update-telegram-config">
            @if ($showModal)
            <form wire:submit.prevent="saveTelegram">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Telegram Name</flux:label>
                        <flux:description>Enter the name of the Telegram Account.</flux:description>
                        <flux:input placeholder="Telegram Name" wire:model="name" />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="p-4" x-data="{
                    logoUrl: null,
                    fileName: '',
                    updatePreview(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.logoUrl = URL.createObjectURL(file);
                            let name = file.name;
                            let ext = name.split('.').pop();
                            let base = name.substring(0, name.lastIndexOf('.'));
                            if (base.length > 20) {
                                base = base.substring(0, 20) + '...';
                            }
                            this.fileName = base + ' .' + ext;
                        } else {
                            this.logoUrl = null;
                            this.fileName = '';
                        }
                    }
                }" x-init="logoUrl = $wire.image ? $wire.image : null;
                if ($wire.image) {
                    let name = $wire.image;
                    name = name.split('/').pop();
                    let ext = name.split('.').pop();
                    let base = name.substring(0, name.lastIndexOf('.'));
                    if (base.length > 20) {
                        base = base.substring(0, 20) + '...';
                    }
                    fileName = base + ' .' + ext;
                }">
                    <flux:field>
                        <flux:label>File</flux:label>
                        <flux:description>Please Select the Telegram Account Picture.</flux:description>
                        <div class="flex justify-start items-center gap-4">
                            <div class="relative flex flex-col items-start">
                                <label
                                    class="inline-block bg-transparent text-zinc-500 hover:text-zinc-800 border border-gray-300 px-4 py-2 rounded cursor-pointer hover:border-black focus:border-black">
                                    Select File
                                    <input type="file" wire:model="logo" @change="updatePreview"
                                        class="absolute left-0 top-0 w-full h-full opacity-0 cursor-pointer"
                                        style="z-index:2;" />
                                </label>

                                <template x-if="fileName">
                                    <div class="text-xs text-gray-500 mt-1 truncate" x-text="fileName"></div>
                                </template>
                            </div>
                            <template x-if="logoUrl">
                                <img :src="logoUrl.startsWith('blob:') ? logoUrl : '/storage/' + logoUrl"
                                    class="h-16 w-16 object-cover rounded-full ml-20!" alt="Logo Preview" />
                            </template>
                        </div>
                        <flux:error name="logo" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Bot Id</flux:label>
                        <flux:description>Enter the Bot Id for the Telegram Account.</flux:description>
                        <flux:input placeholder="Enter Bot Id" wire:model="bot_id" />
                        <flux:error name="bot_id" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Brand</flux:label>
                        <x-combobox label="" name="brand" placeholder="Select Brand" :options="$brands" :selected="$brand" :multiple="false" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:description>Set the status of the Telegram configuration (Active/Inactive).
                        </flux:description>
                        <x-toggle :options="['Inactive', 'Active']" :value="$status"
                            :update="'wire:model.live=status'" />
                        <flux:error name="status" />
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
                    <tr>
                        <th scope="col" class="px-6 py-3 w-80!">Brand</th>
                        <th scope="col" class="px-6 py-3 w-80!">Name</th>
                        <th scope="col" class="px-6 py-3">Image</th>
                        <th scope="col" class="px-6 py-3">Bot Id</th>
                        <th scope="col" class="px-6 py-3">Status</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($telegram as $index => $config)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <td class="px-6 py-4">{{ $config?->brand?->name }}</td>
                        <td class="px-6 py-4">{{ $config->name }}</td>
                        <td class="px-6 py-4">
                            <img src="{{ '/storage/' . $config->image_path }}" class="h-12 w-12 object-cover rounded-full" alt="Logo Preview" />
                        </td>
                        <td class="px-6 py-4">{{ $config->bot_id }}</td>
                        <td class="px-6 py-4">
                            <div class="inline-flex gap-1 items-center">
                                <span class="{{ $config->status ? 'text-green-500' : 'text-red-500' }}">
                                    <i class="fas {{ $config->status ? 'fa-circle-check' : 'fa-circle-xmark' }}"></i>
                                </span>
                                <span class="{{ $config->status ? 'text-green-700' : 'text-red-700' }}">
                                    {{ $config->status ? $activeLabel : $inactiveLabel }}
                                </span>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex gap-2">
                                <flux:tooltip content="Edit Telegram">
                                    <flux:button variant="outline" square size="sm" class="border bg-blue-700/70! text-white! rounded-md" wire:click="editTelegram({{ $config->id }})">
                                        <i class="fas fa-edit"></i>
                                </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Telegram">
                                    <flux:button variant="outline" square size="sm" class="border bg-red-500! text-white! rounded-md" wire:click="deleteTelegram({{ $config->id }})">
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