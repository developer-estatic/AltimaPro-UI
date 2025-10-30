<div class="flex gap-2">
    <input type="text" placeholder="Search..." class="p-1 ps-2 border rounded w-full"
        wire:model.live.debounce.500ms="search" />
    <button class="px-2 py-1 bg-white hover:!bg-endeavour-100 border border-blue-800 text-blue-800 rounded">
        <i class="fa-solid fa-filter"></i>
    </button>
    <button wire:click="exportToExcel"
        class="px-3 py-1 border border-blue-800 bg-white hover:!bg-endeavour-100 text-blue-800 rounded">Export</button>
    <button @click="$dispatch('reload-livewire-component')" class="px-2 py-1 bg-white hover:!bg-endeavour-100  text-blue-800 rounded border border-blue-800">
        <i class="fa-solid fa-rotate-right"></i>
    </button>
    {{-- <button id="filterDropdownButton" x-data
        x-on:click="document.body.hasAttribute('data-show-table-filters-stashed-sidebar') ? document.body.removeAttribute('data-show-table-filters-stashed-sidebar') : document.body.setAttribute('data-show-table-filters-stashed-sidebar', '')"
        data-flux-sidebar-toggle aria-label="{{ __('Toggle sidebar') }}"
        class="w-full lg:hidden md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
        type="button">
        <svg xmlns="http://www.w3.org/2000/svg" aria-hidden="true" class="h-4 w-4 mr-2 text-gray-400"
            viewbox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd"
                d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                clip-rule="evenodd" />
        </svg>
        Filter
    </button> --}}
</div>
