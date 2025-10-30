<div>
    <div class="mx-8">
        <div class="flex justify-between items-center mb-1">
            <h3 class="text-2xl font-bold mb-0">
                <span>User Permissions</span>
            </h3>
        </div>
    </div>

    <form wire:submit.prevent="saveUserPermissions">
        <div class="p-4">
            <label>User</label>
            <select wire:model="user_id" class="form-control">
                <option value="">Select User</option>
                @foreach ($users as $user)
                    <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="p-4">
            <label>Role</label>
            <select wire:model="role_id" class="form-control">
                <option value="">None</option>
                @foreach ($roles as $role)
                    <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                @endforeach
            </select>
        </div>

        <div class="p-4">
            <label>Permissions</label>
            <div>
                @foreach ($permissions as $permission)
                    <label>
                        <input type="checkbox" wire:model="selectedPermissions" value="{{ $permission['id'] }}">
                        {{ $permission['display_name'] }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="p-4">
            <button type="submit" class="btn btn-success">Save</button>
        </div>
    </form>

    <div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">
        <table class="w-full text-left rtl:text-right text-gray-600">
            <thead class="uppercase bg-gray-300">
                <tr class="py-8!">
                    <th scope="col" class="px-6 py-3 w-80!">Name</th>
                    <th scope="col" class="px-6 py-3 w-60!">Email</th>
                    <th scope="col" class="px-6 py-3 w-20!">Role</th>
                    <th scope="col" class="px-6 py-3 w-20!">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="bg-white border-b border-gray-200"
                    wire:key="user-{{ $user->id }}">
                    <td class="px-6 py-2 cursor-pointer">{{ $user->name }}</td>
                    <td class="px-6 py-2">{{ $user->email }}</td>
                    <td class="px-6 py-2">
                        {{ $user->roles->pluck('name')->join(', ') }}
                    </td>
                    <td class="px-6 py-2">
                        <div class="d-flex gap-2 text-xs!">
                            <flux:tooltip content="Edit" extra-classes="px-2!">
                                <flux:button variant="outline" square size="sm"
                                    class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                    wire:click="openModal({{ $user->id }})">
                                    <i class="fas fa-edit"></i>
                                </flux:button>
                            </flux:tooltip>
                            <flux:tooltip content="Delete" extra-classes="px-2!">
                                <flux:button variant="outline" square size="sm"
                                    class=" border-1 bg-red-500! text-white! rounded-md!"
                                    wire:click="deleteUser({{ $user->id }})">
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
