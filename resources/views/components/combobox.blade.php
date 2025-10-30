@props([
    'label' => null,
    'name',
    'placeholder' => 'Select',
    'options' => [],
    'selected' => null,
    'multiple' => false,
    'id' => 'combobox_' . uniqid(),
])

@php $model = $attributes->wire('model')->value(); @endphp

<div x-data="{
    open: false,
    search: '',
    options: {{ json_encode($options) }},
    selected: [],
    multiple: {{ $multiple ? 'true' : 'false' }},

    get filtered() {
        return this.search
            ? this.options.filter(o => o.name.toLowerCase().includes(this.search.toLowerCase()))
            : this.options;
    },

    toggle(option) {
        if (this.multiple) {
            this.isSelected(option.id) ? this.remove(option.id) : this.add(option);
        } else {
            this.selected = [option];
            this.open = false;
        }
        this.search = '';
        this.sync();
    },

    add(option) {
        if (!this.isSelected(option.id)) this.selected.push(option);
    },

    remove(id) {
        this.selected = this.selected.filter(item => item.id !== id);
        this.sync();
    },

    isSelected(id) {
        return this.selected.some(item => item.id === id);
    },

    sync() {
        this.$nextTick(() => {
            const val = this.multiple
                ? this.selected.map(item => item.id)
                : (this.selected[0]?.id || null);

            $wire.dispatchSelf('setComboBoxValue', { value: val, field: '{{ $name }}' });
        });
    },

    init() {
        const selectedIds = @json($selected);
        const ids = this.multiple
            ? (Array.isArray(selectedIds) ? selectedIds : (selectedIds ? [selectedIds] : []))
            : (selectedIds ? [selectedIds] : []);

        this.selected = this.options.filter(option => ids.includes(option.id));
        this.sync();
    }
}" x-init="init()" @click.outside="open = false" class="relative w-full">
    @if ($label)
        <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 mb-1">{{ $label }}</label>
    @endif

    <!-- Trigger -->
    <div @click="open = !open" class="border rounded px-3 py-2 flex items-center justify-between bg-white cursor-pointer">
        <div class="flex flex-wrap items-center gap-2">
            <template x-if="!selected.length">
                <span class="text-sm text-gray-400">{{ $placeholder }}</span>
            </template>
            <template x-for="item in selected" :key="item.id">
                <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded flex items-center gap-1">
                    <span x-text="item.name"></span>
                    <button type="button" @click.stop="remove(item.id)" class="text-xs ml-1">×</button>
                </span>
            </template>
        </div>
        <svg class="w-4 h-4 text-gray-500 transition-transform" :class="{ 'rotate-180': open }"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </div>

    <!-- Dropdown -->
    <div x-show="open" x-transition class="absolute z-10 mt-1 w-full bg-white border rounded shadow max-h-60 overflow-y-auto">
        <input type="text" x-model="search" placeholder="Search..."
               class="w-full px-3 py-2 border-b text-sm focus:outline-none">

        <template x-for="option in filtered" :key="option.id">
            <div @click="toggle(option)" class="px-3 py-2 text-sm hover:bg-gray-100 cursor-pointer flex justify-between">
                <span x-text="option.name"></span>
                <template x-show="isSelected(option.id)">
                    <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                </template>
            </div>
        </template>

        <div x-show="!filtered.length" class="px-3 py-2 text-gray-400 text-sm">No results found</div>
    </div>

    <!-- Hidden Input -->
    <input type="hidden" name="{{ $name }}" wire:model="{{ $model }}" />
</div>