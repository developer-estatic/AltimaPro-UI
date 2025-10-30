@props(['data', 'key'])
<div>
    <div x-data="{
        clearFilter() {
            const radioButtons = document.querySelectorAll('input[type=radio][name=date_range]');
            radioButtons.forEach(radio => radio.checked = false);
            this.$dispatch('clearFilter', {
                operator: '{{ $data['left_filter']['operator'] }}',
                col: '{{ $data['data_key'] }}'
            });
        }
    }">
        <h2 id="accordion-collapse-heading-{{ str_replace(' ', '-', strtolower($key)) }}"
            class="mr-2 flex justify-between bg-pattens-blue items-center">
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
            <a @click="$dispatch('clear-date-range-picker'); clearFilter();" href="javascript:;"
                class="underline text-st-tropaz text-sm text-nowrap mr-2"> Clear
                All</a>
        </h2>
        <div id="accordion-collapse-body-{{ str_replace(' ', '-', strtolower($key)) }}" class="px-2"
            aria-labelledby="accordion-collapse-heading-{{ str_replace(' ', '-', strtolower($key)) }}">
            <div class="flex item-center justify-between pt-2 ps-2 pe-1">
                <div x-data="{
                    showDateRangePickerInput: false
                }" @clear-date-range-picker.window="showDateRangePickerInput = false;"
                    class="flex flex-col flex-grow w-full">
                    <div class="flex items-center gap-8">
                        <div class="flex items-center mb-3">
                            <input id="last_week" type="radio" value="" name="date_range"
                                x-on:click="showDateRangePickerInput = false"
                                wire:click="$dispatch('applyFilter', { 'operator': '{{ $data['left_filter']['operator'] }}', 'col': '{{ $data['data_key'] }}', 'value': ['{{ now()->subWeek()->startOfWeek()->format('Y-m-d H:i:s') }}','{{ now()->subWeek()->endOfWeek()->format('Y-m-d H:i:s') }}'] })"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="last_week" class="ms-2 text-sm font-medium text-gray-900">Last Week</label>
                        </div>
                        <div class="flex items-center mb-3">
                            <input id="last_month" type="radio" value="" name="date_range"
                                x-on:click="showDateRangePickerInput = false"
                                wire:click="$dispatch('applyFilter', { 'operator': '{{ $data['left_filter']['operator'] }}', 'col': '{{ $data['data_key'] }}', 'value': ['{{ now()->subMonth()->startOfMonth()->format('Y-m-d H:i:s') }}', '{{ now()->subMonth()->endOfMonth()->format('Y-m-d H:i:s') }}'] })"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="last_month" class="ms-2 text-sm font-medium text-gray-900">Last Month</label>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex items-center">
                            <input id="specific_date_range" type="radio" value="" name="date_range"
                                x-on:click="showDateRangePickerInput = true"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2">
                            <label for="specific_date_range" class="ms-2 text-sm font-medium text-gray-900">Specific Date
                                Range</label>
                        </div>
                    </div>
                    <div x-show="showDateRangePickerInput">
                        <div x-data>
                            <x-date-range-picker />
                            <span
                                @range-selected.window="
                                        const from = new Date(event.detail.from);
                                        const to = new Date(event.detail.to);

                                        from.setHours(0, 0, 0, 0);
                                        to.setHours(23, 59, 59, 999);

                                        const pad = n => n.toString().padStart(2, '0');
                                        const formatDateTime = (date) => {
                                            return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())} ${pad(date.getHours())}:${pad(date.getMinutes())}:${pad(date.getSeconds())}`;
                                        };

                                        $dispatch('applyFilter', {
                                            operator: '{{ $data['left_filter']['operator'] }}',
                                            col: '{{ $data['data_key'] }}',
                                            value: [formatDateTime(from), formatDateTime(to)]
                                        });
                                    ">
                            </span>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>