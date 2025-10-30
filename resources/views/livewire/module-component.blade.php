@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Modules"></x-partials.header>
</x-slot>

<div x-data="{ loading: $wire.entangle('loading').live }">
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">
                <span>
                    Modules
                </span>
            </h3>
            @if (canPerformAction('settings.modules.create'))
            <flux:tooltip content="Add Module" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openCreateModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>
        <x-modal name="create-update-module">
            @if ($modalVisible)
            <form wire:submit.prevent="saveModule" x-data="{
                    moduleNameAlpine: $wire.entangle('name'),
                    routeAlpine: $wire.entangle('route'),
                    menuType: $wire.entangle('menu_type'),
                    parentId: $wire.entangle('parent_id'),
                    init() {
                        this.$watch('parentId', value => {
                            if (this.menuType === 'SECONDARY' && (value === '' || value === null)) {
                                this.menuType = 'PRIMARY';
                            }
                        });
                        this.$watch('menuType', value => {
                            if (value === 'PRIMARY') {
                                this.parentId = '';
                            }
                        });
                    }
                }" x-init="init()">
                <div class="p-4">
                    <flux:field>
                        <flux:label>Menu Type</flux:label>
                        <flux:description>Select the menu type for this module.</flux:description>
                        <select x-model="menuType" wire:model="menu_type" class="form-control">
                            <option value="PRIMARY">Primary</option>
                            <option value="SECONDARY">Secondary</option>
                        </select>
                        <flux:error name="menu_type" />
                    </flux:field>
                </div>
                <div class="p-4" x-show="menuType === 'SECONDARY'">
                    <flux:field>
                        <flux:label>Parent Module</flux:label>
                        <flux:description>Select the parent module if applicable.</flux:description>
                        <select x-model="parentId" wire:model="parent_id" class="form-control">
                            <option value="">None</option>
                            @foreach ($modules as $module)
                            <option value="{{ $module['id'] }}">{{ $module['name'] }}</option>
                            @endforeach
                        </select>
                        <flux:error name="parent_id" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Module Name</flux:label>
                        <flux:description>Enter the name of the module.</flux:description>
                        <flux:input placeholder="Enter the name of the module." x-model="moduleNameAlpine"
                            @input="routeAlpine =
                                    moduleNameAlpine
                                        .toLowerCase()
                                        .replace(/[_\s]+/g, '-')
                                        .replace(/[^a-z0-9\-]/g, '')
                                        .replace(/-+/g, '-')
                                        .replace(/^-+|-+$/g, '')
                                        + '.index';
                                    $wire.set('name', moduleNameAlpine, true); $wire.set('route', routeAlpine, true);" />
                        <flux:error name="name" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Route</flux:label>
                        <flux:description>Route is auto-generated from module name.</flux:description>
                        <flux:input placeholder="e.g. settings.index" x-model="routeAlpine"
                            class:input="bg-gray-200!" />
                        <flux:error name="route" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>List Order</flux:label>
                        <flux:description>Select the Listing Order.</flux:description>
                        <flux:input placeholder="Enter the list order." wire:model="order" inputmode="numeric"
                            pattern="[0-9]*" @input="
                                    if ($event.target.value && /[^0-9]/.test($event.target.value)) {
                                        $event.target.value = $event.target.value.replace(/[^0-9]/g, '');
                                        $dispatch('input', $event.target.value);
                                    }
                                " />
                        <flux:error name="order" />
                    </flux:field>
                </div>

                <div class="p-4">
                    <flux:field>
                        <flux:label>Status</flux:label>
                        <flux:description>Set the status of the module (Active/Inactive).</flux:description>
                        <x-toggle :options="['Inactive', 'Active']" :value="$status"
                            :update="'wire:model.live=status'" />
                        <flux:error name="status" />
                    </flux:field>
                </div>
                <div class="p-4">
                    <flux:field>
                        <flux:label>Permissions</flux:label>
                        <flux:description>Manage permissions for this module.</flux:description>

                        <div x-data="{
                                permissions: $wire.entangle('permissions'),
                                newPermission: { name: '', display_name: '' },
                                permissionError: '',
                                init() {},
                                get allSelected() {
                                    return this.permissions.every(permission => permission.selected);
                                },
                                toggleSelectAll() {
                                    const selectAll = !this.allSelected;
                                    this.permissions.forEach(permission => permission.selected = selectAll);
                                },
                                addPermission() {
                                    this.permissionError = '';
                                    const newDisplay = this.newPermission.display_name.trim();
                                    // kebab-case the display name for permission name
                                    const newPerm = this.newPermission.name.trim()
                                    {{-- const newPerm = newDisplay
                                        .toLowerCase()
                                        .replace(/[_\s]+/g, '-')
                                        .replace(/[^a-z0-9\-]/g, '')
                                        .replace(/-+/g, '-')
                                        .replace(/^-+|-+$/g, ''); --}}
                                    if (!newPerm || !newDisplay) {
                                        this.permissionError = 'Permission display name is required.';
                                        return;
                                    }
                                    if (this.permissions.some(p => p.name === newPerm)) {
                                        this.permissionError = 'A permission with this name already exists.';
                                        return;
                                    }
                                    this.permissions.push({ name: newPerm, display_name: newDisplay, selected: true, _custom: true });
                                    this.newPermission = { name: '', display_name: '' };
                                }
                            }" x-init="init()">
                            <div class="flex items-center mb-4">
                                <input id="select-all-checkbox" type="checkbox" @change="toggleSelectAll"
                                    :checked="allSelected"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500">
                                <label for="select-all-checkbox" class="ms-2 text-sm font-medium text-gray-900">Select
                                    All</label>
                            </div>
                            <div class="flex flex-row flex-wrap mb-2 gap-4 items-center">
                                <template x-for="(permission, idx) in permissions" :key="permission.name">
                                    <div class="flex flex-row items-center mb-2 gap-2">
                                        <input type="checkbox" :id="'permission-' + permission.name"
                                            value="permission.name" @change="permission.selected = !permission.selected"
                                            :checked="permission.selected"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500">
                                        <label :for="'permission-' + permission.name"
                                            class="text-sm font-medium text-gray-900"
                                            x-text="permission.display_name"></label>
                                        <template x-if="permission._custom === true">
                                            <flux:tooltip content="Delete Permission" extra-classes="px-2!">
                                                <flux:button variant="subtle" size="sm" icon="x-circle"
                                                    class="rounded-md! text-red-600!"
                                                    @click="permissions.splice(idx, 1)">
                                                </flux:button>
                                            </flux:tooltip>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <div class="mt-4">
                                <flux:label class="mb-2!">Add Specific Permission</flux:label>
                                <div class="flex items-center gap-4 mt-1">
                                    <div class="flex flex-col">
                                        <flux:label class="mb-1!">Display Name</flux:label>
                                        <flux:input placeholder="e.g.Create/Edit" x-model="newPermission.display_name"
                                            @input="
                                                    newPermission.name = newPermission.display_name
                                                        .toLowerCase()
                                                        .replace(/[_\s]+/g, '-')
                                                        .replace(/[^a-z0-9\-]/g, '')
                                                        .replace(/-+/g, '-')
                                                        .replace(/^-+|-+$/g, '')
                                                " class="w-full" />
                                    </div>
                                    <div class="flex flex-col">
                                        <flux:label class="mb-1!">Permission</flux:label>
                                        <flux:input x-model="newPermission.name" class="w-full" />
                                    </div>
                                    <flux:button variant="primary" class="rounded-md! mt-3 hover:bg-persian-green"
                                        size="sm" @click="addPermission">
                                        Add
                                    </flux:button>
                                </div>
                                <template x-if="permissionError">
                                    <div class="text-red-600 text-xs mb-2" x-text="permissionError"></div>
                                </template>
                            </div>

                        </div>

                        <flux:error name="permissions" />
                    </flux:field>
                </div>
                <div class="p-4 mt-4 flex justify-end">
                    <flux:button wire:click="hideModal" variant="subtle">Cancel</flux:button>
                    <flux:button variant="primary" type="submit" class="rounded">Save</flux:button>
                </div>
            </form>
            @endif
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4" x-data="{
            handle() {
                const rows = Array.from($el.querySelectorAll('tbody tr'));
                const items = rows.map(row => ({
                    el: row,
                    id: row.dataset.id,
                    parent_id: row.dataset.parentId || null
                }));

                const childrenMap = {};
                const parentMap = {};

                // Group children under their parent_id
                items.forEach(item => {
                    if (!childrenMap[item.parent_id]) childrenMap[item.parent_id] = [];
                    childrenMap[item.parent_id].push(item);
                    parentMap[item.id] = item.parent_id;
                });

                const result = [];

                function assignOrder(parentId = null) {
                    const children = childrenMap[parentId] || [];

                    children.forEach((child, index) => {
                        const newOrder = index + 1;

                        // Update order in DOM
                        const orderCell = child.el.querySelector('td:nth-child(5) span');
                        if (orderCell) orderCell.innerText = newOrder;

                        // Find actual new parent based on DOM
                        const newParentRow = child.el.closest('tr[data-id]')?.previousElementSibling;
                        let newParentId = null;

                        if (parentId !== null) {
                            newParentId = parentId;
                        }

                        // Update internal state for result
                        result.push({
                            id: child.id,
                            order: newOrder,
                            parent_id: newParentId
                        });

                        // Recursive assign children
                        assignOrder(child.id);
                    });
                }

                assignOrder();

                // Send data to Livewire
                $wire.dispatchSelf('updateOrderAndParent', { value: result });
            }
        }">
            <table class="w-full text-left rtl:text-right text-gray-600">
                <thead class="uppercase bg-gray-300">
                    <tr>
                        <th class="whitespace-nowrap px-6 py-3 w-80!"></th>
                        <th class="whitespace-nowrap px-6 py-3 w-80!">Name</th>
                        <th class="whitespace-nowrap px-6 py-3">Parent</th>
                        <th class="whitespace-nowrap px-6 py-3">Menu Type</th>
                        <th class="whitespace-nowrap px-6 py-3">Base Route</th>
                        <th class="whitespace-nowrap px-6 py-3">Order</th>
                        <th class="whitespace-nowrap px-6 py-3">Status</th>
                        <th class="whitespace-nowrap px-6 py-3">Permissions</th>
                        <th class="whitespace-nowrap px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody x-sort="handle">
                    @foreach ($modules as $module)
                    <tr class="bg-white border-b @if ($module?->parent?->parent) mx-20! @elseif($module?->parent) mx-8! @else mx-0! @endif"
                        x-sort:item data-id="{{ $module->id }}" data-parent-id="{{ $module->parent_id ?? '' }}">
                        <td class="px-6 py-4 whitespace-nowrap cursor-pointer">
                            <i class="fa fa-arrows" aria-hidden="true"></i>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $module->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($module?->parent?->parent)
                            {{ $module?->parent?->parent->name }} &raquo; {{ $module?->parent?->name }}
                            @elseif($module?->parent)
                            {{ $module?->parent->name }}
                            @else
                            <span class="text-gray-500">—</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $module->menu_type === 'PRIMARY' ? 'Primary' : 'Secondary' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $module->route }}</td>
                        <td class="px-6 py-4 whitespace-nowrap"><span>{{ $module->order }}</span></td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <x-toggle :options="['Inactive', 'Active']" :value="$module->status"
                                :update="'wire:click=toggleStatus(' . $module->id . ')'" />
                        </td>
                        <td class="px-6 py-4">
                            {{ implode(', ', $module->permissions->pluck('display_name')->toArray()) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex gap-2">
                                <flux:tooltip content="Edit Module">
                                    <flux:button variant="outline" square size="sm"
                                        class="border bg-blue-700/70! text-white! rounded-md"
                                        wire:click="editModule({{ $module->id }})">
                                        <i class="fas fa-edit"></i>
                                    </flux:button>
                                </flux:tooltip>
                                <flux:tooltip content="Delete Module">
                                    <flux:button variant="outline" square size="sm"
                                        class="border bg-red-500! text-white! rounded-md"
                                        wire:click="deleteModule({{ $module->id }})">
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
    <div class="w-full h-full fixed top-0 left-0 bg-white opacity-75 z-50" x-show="loading">
        <div class="flex justify-center items-center mt-[50vh]">
            <div class="fas fa-circle-notch fa-spin fa-5x text-primary/100"></div>
        </div>
    </div>
</div>