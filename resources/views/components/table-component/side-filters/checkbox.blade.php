@props(['data', 'key'])
<?php
if($data['values'] == null || count($data['values']) == 0) {
    $chunks = [];
} else {
    $chunks = array_chunk($data['values'], ceil(count($data['values']) / 2));
}

?>
<div x-data="{
    selected: [],
    toggleSelection(value) {
        if (this.selected.includes(value)) {
            this.selected = this.selected.filter(item => item !== value); // Remove value if already selected
        } else {
            this.selected.push(value); // Add value if not selected
        }
        this.sendToLivewire(); // Dispatch updated values to Livewire
    },
    toggleSelectAll(values) {
        if (this.selected.length === values.length) {
            this.selected = []; // Deselect all if all are selected
        } else {
            this.selected = [...values]; // Select all
        }
        this.sendToLivewire(); // Dispatch updated values to Livewire
    },
    clearFilter() {
        this.selected = [],
        this.$dispatch('clearFilter', {
            operator: '{{ $data['left_filter']['operator'] }}',
            col: '{{ $data['data_key'] }}'
        });
    },
    sendToLivewire() {
        this.$dispatch('applyFilter', {
            operator: '{{ $data['left_filter']['operator'] }}',
            col: '{{ $data['data_key'] }}',
            value: this.selected
        });
    }
}">
    <h2 id="accordion-collapse-heading-{{ str_replace(' ', '-', strtolower($key)) }}" class="mr-2 flex justify-between bg-pattens-blue items-center">
        <button type="button"
            class="flex items-center justify-between w-full p-2 bg-pattens-blue text-sm font-medium rtl:text-right rounded-sm gap-3 z-10"
            data-accordion-target="#accordion-collapse-body-{{ str_replace(' ', '-', strtolower($key)) }}"
            aria-expanded="true" aria-controls="accordion-collapse-body-{{ str_replace(' ', '-', strtolower($key)) }}">
            <div class="flex items-center gap-2">
                <svg data-accordion-icon class="text-dodger-blue w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5 5 1 1 5" />
                </svg>
                <span class="text-st-tropaz text-sm"> {{ $key }} </span>
            </div>
        </button>
        <a @click="clearFilter" href="javascript:;"
            class="underline text-st-tropaz text-sm text-nowrap mr-2"> Clear All</a>
    </h2>
    <div id="accordion-collapse-body-{{ str_replace(' ', '-', strtolower($key)) }}" class="px-2"
        aria-labelledby="accordion-collapse-heading-{{ str_replace(' ', '-', strtolower($key)) }}">
        <div class="flex item-center justify-between py-2 ps-2 pe-1 max-h-40 overflow-y-scroll mb-3">
            @foreach ($chunks as $k => $chunk)
                <div class="flex flex-row flex-wrap space-y-1">
                    @if (isset($data['has_select_all']) && $data['has_select_all'] == true && $k == 0)
                        <div class="flex items-center mb-2">
                            <input id="select_all" type="checkbox"
                                @click="toggleSelectAll({{ json_encode($data['values']) }})"
                                :checked="selected.length === {{ count($data['values']) }}" value=""
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                            <label for="select_all" class="ms-2 text-sm font-medium text-gray-900">Select
                                All</label>
                        </div>
                    @endif
                    @foreach ($chunk as $label)
                        <div class="flex items-center mb-2">
                            <input id="{{ Str::slug($label) }}" type="checkbox" value="{{ $label }}"
                                @click="toggleSelection('{{ $label }}')"
                                :checked="selected.includes('{{ $label }}')" name="{{ $data['data_key'] }}[]"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2">
                            <label for="{{ Str::slug($label) }}"
                                class="ms-2 text-sm font-medium text-gray-900">{{ $label }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</div>
