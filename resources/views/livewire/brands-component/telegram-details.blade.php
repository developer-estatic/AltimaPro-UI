@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp
<div>
    <div class="flex items-center justify-between p-3 md:p-5 border-b rounded-t border-gray-200 bg-blue-100">
        <h5 class="font-semibold text-gray-900 mb-0">
            {{ $title }}
        </h5>
    </div>
    <div class="overflow-x-auto table-responsive">
        <table class="table table-bordered table-striped mb-0">
            <thead class="">
                <tr>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Brand</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Name</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Bot Id</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Image</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Status</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($telegramDetails as $telegram)
                <tr>
                    <td class="px-6 py-2 text-start align-middle text-nowrap w-min">{{ $telegram?->brand?->name ?? 'N/A'
                        }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $telegram->name }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $telegram->bot_id }}</td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            <img src="{{ '/storage/' . $telegram->image_path }}"
                                class="h-12 w-12 object-cover rounded-full" alt="Logo Preview" />
                        </span>
                    </td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $telegram->status ? $activeLabel : $inactiveLabel }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ __('No Telegram details found.') }}
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>