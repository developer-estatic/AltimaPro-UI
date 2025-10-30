@props(['checkbox', 'data', 'columns'])

@foreach ($data as $key => $value)
    <tr class="border-b dark:border-gray-700">
        @foreach ($columns as $column => $columnData)
            @if ($column == 'checkbox')
                <td class="px-3 py-2 w-[6px] text-center">
                    <input id="row_{{ $value->{$columnData['data_key']} }}" type="checkbox" value="{{ $value->{$columnData['data_key']} }}" x-data="{ value: '{{ $value->{$columnData['data_key']} }}' }"
                        class="w-5 h-5 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 focus:ring-2 row_checkbox" @click="addRemoveFromSelection(value)" :checked="selectedRows.includes(value)">
                </td>
                @continue
            @endif
            @php
                // Initialize the column value as null
                $columnValue = null;

                // Check if the column has a 'data_key'
                if (isset($columnData['data_key'])) {
                    $dataKeyParts = explode('.', $columnData['data_key']);

                    // If the 'data_key' has multiple parts (indicating nested relation)
                    if (count($dataKeyParts) > 1) {
                        // Start from the root object
                        $columnValue = $value;

                        // Loop through each part of the data key to access nested relations
                        foreach ($dataKeyParts as $part) {
                            // Access the current relation dynamically
                            $columnValue = $columnValue->{$part} ?? null;
                            if (is_null($columnValue)) {
                                break; // If at any point the value is null, stop traversing
                            }
                        }
                    } else {
                        // Direct key, no relation
                        $columnValue = $value->{$columnData['data_key']} ?? null;
                    }
                }
            @endphp

            <td class="px-4 py-3">
                <div class="@if (isset($columnData['extra'])) flex items-center gap-1 @endif">
                    @if (isset($columnData['extra']['has_initials']))
                        <span class=" }}"></span>
                        <flux:avatar circle size="sm" :name="$columnValue"
                            class="{{ $columnData['extra']['has_initials']['classes'] }}" />
                    @endif
                    @if (isset($columnData['extra']['icons']))
                        @foreach ($columnData['extra']['icons'] as $ick => $icon)
                            <span class=" {{ $ick }} {{ $icon['classes'] }}"></span>
                        @endforeach
                    @endif
                    <span class="w-full text-nowrap @if (isset($columnData['extra'])) ms-1 @endif">
                        @if (isset($columnData['is_link']))
                            <a href="javascript:;" class="!no-underline text-endeavour-500"
                                target="_blank">{{ $columnValue }}</a>
                        @else
                            {{ $columnValue }}
                        @endif
                    </span>
                </div>
            </td>
        @endforeach
    </tr>
@endforeach
