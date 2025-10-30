@php
    $activeLabel = __('Active');
    $inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Role Management"></x-partials.header>
</x-slot>

<div>
    <div class="flex-1 p-8 bg-gray-50 text-medium text-gray-500 dark:text-gray-400 dark:bg-gray-800 rounded-lg">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">
                <span>Roles</span>
            </h3>
            @if(canPerformAction('settings.roles.create'))
            <flux:tooltip content="Add Role" extra-classes="px-2!">
                <flux:button variant="primary" size="sm" icon="plus" class="rounded-md!" wire:click="openModal">
                </flux:button>
            </flux:tooltip>
            @endif
        </div>
        <x-modal name="create-update-role">
            @if ($modalVisible)
                <form wire:submit.prevent="saveRole">
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Role Name</flux:label>
                            <flux:input placeholder="Enter role name" wire:model="name" />
                            <flux:error name="name" />
                        </flux:field>
                    </div>
                    <div class="p-4">
                        <flux:field>
                            <flux:label>Parent Role</flux:label>
                            <select wire:model="parent_id" class="form-control">
                                <option value="">None</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            <flux:error name="parent_id" />
                        </flux:field>
                    </div>

                    <div class="p-4 mt-4 flex justify-end gap-2">
                        <flux:button class="cursor-pointer" wire:click="hideModal" variant="subtle">Cancel</flux:button>
                        <flux:button type="submit" variant="primary" class="cursor-pointer rounded hover:bg-persian-green">Save</flux:button>
                    </div>
                </form>
            @endif
        </x-modal>

        <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
            <table class="w-full text-left rtl:text-right text-gray-600">
                <thead class="uppercase bg-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3">Name</th>
                        <th scope="col" class="px-6 py-3">Parent</th>
                        <th scope="col" class="px-6 py-3">Permissions</th>
                        <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($this->roles as $role)
                        <tr wire:key="role-{{ $role->id }}"
                            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="px-6 py-4 cursor-pointer">{{ $role->name }}</td>
                            <td class="px-6 py-4">
                                {{ $role->parent_id ? $roles->firstWhere('id', $role->parent_id)->name : '' }}
                            </td>
                            <td class="px-6 py-4">
                                @if (!currentUserHasRoleId($role->id))
                                    <div class="flex gap-4">
                                        <a href="javascript:void(0)"
                                            wire:click="openPrivilegesModal({{ $role->id }})"
                                            class="text-black! hover:text-blue-500! bg-transparent!">
                                            Privileges
                                        </a>
                                        <span> | </span>
                                        <a href="javascript:void(0)"
                                            wire:click="openMenuAccessModal({{ $role->id }})"
                                            class="text-black! hover:text-blue-500! bg-transparent!">
                                            Menu Access
                                        </a>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex gap-2">
                                    <flux:tooltip content="Edit Role">
                                        <flux:button variant="outline" square size="sm"
                                            class="border bg-blue-700/70! text-white! rounded-md"
                                            wire:click="openModal({{ $role->id }})">
                                            <i class="fas fa-edit"></i>
                                        </flux:button>
                                    </flux:tooltip>
                                    @if (!currentUserHasRoleId($role->id))
                                        <flux:tooltip content="Delete Role">
                                            <flux:button variant="outline" square size="sm"
                                                class="border bg-red-500! text-white! rounded-md"
                                                wire:click="deleteRole({{ $role->id }})">
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
    <x-modal name="menu-access-modal">
        <div
            class="flex items-center justify-between p-4 pb-2 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h4 class="font-semibold text-gray-900 ">
                Menu Access
            </h4>
        </div>
        <form wire:submit.prevent="saveMenuAccess">
            <div class="p-4">
                <flux:field>
                    <flux:label>Select Brand</flux:label>
                    <select wire:model.live="selectedBrand" class="form-control">
                        <option value="">--- Select Brand ---</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </flux:field>
            </div>
            @if ($selectedBrand)
                <div class="p-4">
                    @foreach ($modules as $module)
                        @php
                            $indexPermission = $module->permissions->first(
                                fn($permission) => Str::contains($permission->name, 'index'),
                            );
                        @endphp
                        @if ($indexPermission)
                            <div class="w-full py-2 px-2 bg-gray-100!">
                                <div class="flex items-center">
                                    <input type="checkbox" id="{{ $indexPermission->name }}"
                                        wire:model="selectedMenuItems"
                                        value="{{ $indexPermission ? $indexPermission->id : '' }}"
                                        class="form-checkbox" @if (in_array($indexPermission ? $indexPermission->id : '', $selectedMenuItems)) checked @endif />
                                    <label class="ml-2 font-semibold! text-sm text-gray-700"
                                        for="{{ $indexPermission->name }}">{{ $module->name }}</label>
                                </div>
                            </div>
                        @endif
                        <div class="grid grid-cols-3 gap-4 mt-4 px-3 mb-8">
                            @foreach ($module->children as $child)
                                @php
                                    $childIndexPermission = $child->permissions->first(
                                        fn($permission) => Str::contains($permission->name, 'index'),
                                    );
                                @endphp
                                @if ($childIndexPermission)
                                    <div class="@if ($child->children->isNotEmpty()) col-span-3 @else col-span-1 @endif">
                                        <input type="checkbox" id="{{ $child->name }}" wire:model="selectedMenuItems"
                                            value="{{ $childIndexPermission ? $childIndexPermission->id : '' }}"
                                            class="form-checkbox" @if (in_array($childIndexPermission ? $childIndexPermission->id : '', $selectedMenuItems)) checked @endif />
                                        <label class="ml-2 text-sm text-gray-700"
                                            for="{{ $child->name }}">{{ $child->name }}</label>

                                        @if ($child->children->isNotEmpty())
                                            <div class="grid grid-cols-3 gap-2 mt-4 px-4 mb-2">
                                                @foreach ($child->children as $grandChild)
                                                    @php
                                                        $grandChildIndexPermission = $grandChild->permissions->first(
                                                            fn($permission) => Str::contains(
                                                                $permission->name,
                                                                'index',
                                                            ),
                                                        );
                                                    @endphp
                                                    @if ($grandChildIndexPermission)
                                                        <div class="flex items-center w-full flex-wrap">
                                                            <div class="flex items-center">
                                                                <input type="checkbox" id="{{ $grandChild->name }}"
                                                                    wire:model="selectedMenuItems"
                                                                    value="{{ $grandChildIndexPermission ? $grandChildIndexPermission->id : '' }}"
                                                                    class="form-checkbox"
                                                                    @if (in_array($grandChildIndexPermission ? $grandChildIndexPermission->id : '', $selectedMenuItems)) checked @endif />
                                                                <label class="ml-2 text-sm text-gray-700"
                                                                    for="{{ $grandChild->name }}">{{ $grandChild->name }}</label>
                                                            </div>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endforeach

                    <div class="p-4 flex justify-end gap-2">
                        <flux:button class="cursor-pointer" wire:click="hideModal" variant="subtle">Cancel</flux:button>
                        <flux:button type="submit" variant="primary" class="cursor-pointer rounded hover:bg-persian-green">Save</flux:button>
                    </div>
                </div>
            @endif
        </form>
    </x-modal>
    <x-modal name="privileges-modal">
        <div
            class="flex items-center justify-between p-4 pb-2 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
            <h4 class="font-semibold text-gray-900 ">
                Privileges
            </h4>
        </div>
        <form wire:submit.prevent="savePrivileges">
            <div class="p-4">
                <flux:field>
                    <flux:label>Select Brand</flux:label>
                    <select wire:model.live="selectedBrand" class="form-control">
                        <option value="">--- Select Brand ---</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </flux:field>
            </div>
            @if ($selectedBrand)
                <div class="p-4">
                    @foreach ($modulesWithoutParentFiltered as $module)
                        <div class="w-full py-2 px-2 bg-gray-100!">
                            <div class="flex items-center">
                                <label class="ml-2 font-semibold! text-sm text-gray-700">{{ $module->name }}</label>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mt-4 px-3 mb-8">
                            @foreach ($module->permissions as $permission)
                                <div class="flex items-center w-full flex-wrap">
                                    <input type="checkbox" id="{{ $permission->name }}"
                                        wire:model="selectedPrivileges" value="{{ $permission->id }}"
                                        class="form-checkbox" @if (in_array($permission->id, $selectedPrivileges)) checked @endif />
                                    <label class="ml-2 text-sm text-gray-700"
                                        for="{{ $permission->name }}">{{ $permission->display_name }}</label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach

                    <div class="p-4 flex justify-end gap-2">
                        <flux:button class="cursor-pointer" wire:click="hideModal" variant="subtle">Cancel</flux:button>
                        <flux:button type="submit" variant="primary" class="cursor-pointer rounded hover:bg-persian-green">Save</flux:button>
                    </div>
                </div>
            @endif
        </form>
    </x-modal>
    <x-modal name="give-permission-to-role-or-user-modal">
        <form
            @if ($lastActionName == 'saveMenuAccess') wire:submit.prevent="saveMenuAccess(true)" @else wire:submit.prevent="savePrivileges(true)" @endif>
            <div
                class="flex items-center justify-between p-4 pb-2 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                <h4 class="font-semibold text-gray-900 ">
                    Give Permission to Role or User
                </h4>
            </div>
            <div class="p-4">
                <flux:field>
                    <flux:label>Select Role or User</flux:label>
                    <select wire:model.live="selectedRoleOrUser" class="form-control">
                        <option value="">--- Select an Option --- </option>
                        <option value="role">Role</option>
                        <option value="user">User</option>
                    </select>
                    @if ($errors->first('selectedRoleOrUser'))
                        <flux:error name="selectedRoleOrUser" message="This field is required." />
                    @endif
                </flux:field>
            </div>
            @if ($selectedRoleOrUser === 'user')
                <div class="p-4" wire:ignore>
                    <flux:field>
                        <flux:label>Select Users</flux:label>
                        <x-combobox label="" name="selectedRoleUsers" placeholder="Select Users"
                            :options="$roleUsers" :selected="$selectedRoleUsers" :multiple="true" />
                        @if ($errors->first('selectedRoleUsers'))
                            <flux:error name="selectedRoleUsers" message="Please select some users" />
                        @endif
                    </flux:field>
                </div>
            @endif
            <div class="p-4">
                <div class="p-4 flex justify-end gap-2">
                    <flux:button class="cursor-pointer" wire:click="hideModal" variant="subtle">Cancel
                    </flux:button>
                    <flux:button type="submit" variant="primary" class="cursor-pointer rounded hover:bg-persian-green">Save
                    </flux:button>
                </div>
            </div>
        </form>
    </x-modal>
</div>
