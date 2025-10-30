@props(['columns', 'conditions', 'filter-options', 'records-length'])
    <tr>
        @php $counter = 0; @endphp
        @foreach ($columns as $k => $col)
            @php
                $counter++;
                $isActiveSort = $conditions['sort_by']['column'] === $col['data_key'];
                $sortDir = $isActiveSort ? $conditions['sort_by']['sort_order'] : null;
            @endphp
            <th class="px-3 py-2 text-nowrap @if ($k == 'checkbox') w-[6px] text-center @endif">
                @if ($k == 'checkbox')
                    <input id="select_all_rows" type="checkbox" value="" @click="toggleSelectAll()"
                        :checked="selectedRows.length > 0 && selectedRows.length == {{ $recordsLength }}"
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                @else
                    <div class="flex justify-between items-center">
                        <span>
                            {{ $k }}
                        </span>
                        @if (!empty($col) && isset($col['table_head_filter']) && $col['table_head_filter'] === true)
                            <flux:icon.funnel variant="outline" class="cursor-pointer size-4"
                                id="dropdownSearchButton-{{ $counter }}"
                                data-dropdown-toggle="dropdownSearch-{{ $counter }}" />
                            <!-- Dropdown menu -->
                            <div id="dropdownSearch-{{ $counter }}"
                                class="z-10 hidden bg-white rounded-lg shadow-sm w-60 dark:bg-gray-700">
                                <ul class="max-h-48 px-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="dropdownSearchButton-{{ $counter }}">
                                    @php
                                        $filtersCounter = 0;
                                    @endphp
                                    @foreach ($filterOptions['top_filters'][$col['data_key']] as $filterOption)
                                        @php
                                            $filtersCounter++;
                                        @endphp
                                        <li>
                                            <div
                                                class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                                <input id="checkbox-item-{{ $filtersCounter }}-{{ $counter }}"
                                                    type="checkbox" value=""
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="checkbox-item-{{ $filtersCounter }}-{{ $counter }}"
                                                    class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">{{ $filterOption }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                    {{-- <li>
                                        <div
                                            class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="checkbox-item-11" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="checkbox-item-11"
                                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Bonnie
                                                Green</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input checked id="checkbox-item-12" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="checkbox-item-12"
                                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Jese
                                                Leos</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="checkbox-item-13" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="checkbox-item-13"
                                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Michael
                                                Gough</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="checkbox-item-14" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="checkbox-item-14"
                                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Robert
                                                Wall</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="checkbox-item-15" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="checkbox-item-15"
                                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Joseph
                                                Mcfall</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="checkbox-item-16" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="checkbox-item-16"
                                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Leslie
                                                Livingston</label>
                                        </div>
                                    </li>
                                    <li>
                                        <div
                                            class="flex items-center p-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">
                                            <input id="checkbox-item-17" type="checkbox" value=""
                                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                            <label for="checkbox-item-17"
                                                class="w-full ms-2 text-sm font-medium text-gray-900 rounded-sm dark:text-gray-300">Roberta
                                                Casas</label>
                                        </div>
                                    </li> --}}
                                </ul>
                            </div>
                        @endif
                        @if (!empty($col) && isset($col['sortable']) && $col['sortable'] === true)
                            <div class="flex flex-col">
                                <span
                                    class="cursor-pointer icon-[fa6-solid--sort-up] text-lg w-4 relative z-10 -mb-2 opacity-{{ $sortDir === 'asc' ? 100 : 50 }}"
                                    wire:click="$dispatch('sortChanged', { col: '{{ $col['data_key'] }}', dir: 'asc' })"></span>
                                <span
                                    class="cursor-pointer icon-[fa6-solid--sort-down] text-lg w-4 relative z-10 mt-1 opacity-{{ $sortDir === 'desc' ? 100 : 50 }}"
                                    wire:click="$dispatch('sortChanged', { col: '{{ $col['data_key'] }}', dir: 'desc' })"></span>
                            </div>
                        @endif
                    </div>
                @endif
            </th>
        @endforeach
    </tr>