@props(['data', 'key'])
<?php

if($data['values'] == null || count($data['values']) == 0) {
    $chunks = [];
} else {
    $chunks = array_chunk($data['values'], ceil(count($data['values']) / 2));
}
?>
<div x-data="{
    selectedValues: [],
    allValues: {{ json_encode($data['values']) }},
    toggleSelectAll(event) {
        if (event.target.checked) {
            this.selectedValues = [...this.allValues]; // Select all values
        } else {
            this.selectedValues = []; // Deselect all values
        }
        this.resetSelect();
        this.sendToLivewire(); // Dispatch updated values to Livewire
    },
    addSelectedValue(value, text) {
        if (!this.selectedValues.includes(value)) {
            this.selectedValues.push(value); // Add value if not already selected
        }
        this.sendToLivewire(); // Dispatch updated values to Livewire
    },
    removeSelectedValue(index) {
        this.selectedValues.splice(index, 1); // Remove value by index
        this.resetSelect();
        this.sendToLivewire(); // Dispatch updated values to Livewire
    },
    clearFilter() {
        this.selectedValues = [];
        this.resetSelect();
        this.$dispatch('clearFilter', {
            operator: '{{ $data['left_filter']['operator'] }}',
            col: '{{ $data['data_key'] }}'
        });
    },
    sendToLivewire() {
        this.$dispatch('applyFilter', {
            operator: '{{ $data['left_filter']['operator'] }}',
            col: '{{ $data['data_key'] }}',
            value: this.selectedValues
        });
    },
    resetSelect() {
        this.allValues = [];
        this.$nextTick(() => {
            this.allValues = {{ json_encode($data['values']) }};
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

    <div class="flex flex-col space-y-1 px-2">
        <div class="flex items-center mt-2 mb-3">
            <input id="select_all_{{ str_replace(' ', '-', strtolower($key)) }}" type="checkbox"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2"
                x-on:change="toggleSelectAll" :checked="selectedValues.length && selectedValues.length == allValues.length">
            <label for="select_all_{{ str_replace(' ', '_', strtolower($key)) }}" class="ms-2 text-sm font-medium text-gray-900">
                Select All
            </label>
        </div>

        <form class="w-full mx-auto">
            <label for="{{ str_replace(' ', '_', strtolower($key)) }}" class="block mb-2 text-sm font-medium text-gray-900 ">
                Select an option
            </label>
            <select id="{{ str_replace(' ', '_', strtolower($key)) }}"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 mb-1"
                x-on:change="
                    let selectedValue = $event.target.value;
                    if (!selectedValues.includes(selectedValue) && selectedValue !== 'Choose an option') {
                        addSelectedValue(selectedValue);
                    }
                ">
                <option selected>Choose an option</option>
                <template x-for="value in allValues" :key="value">
                    <option x-bind:value="value" x-text="value"></option>
                </template>
            </select>
        </form>
    </div>

    <div class="flex px-2 my-1 flex-wrap">
        <template x-for="(dataValue, index) in selectedValues" :key="dataValue">
            <flux:badge variant="pill" icon="flag" class="my-2 mx-1">
                <span x-text="dataValue"></span>
                <flux:icon.x-mark class="cursor-pointer size-4 text-midnight-blue"
                    x-on:click="removeSelectedValue(index)" />
            </flux:badge>
        </template>
    </div>
</div>
</div>