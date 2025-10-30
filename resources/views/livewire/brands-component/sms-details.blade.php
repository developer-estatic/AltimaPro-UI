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
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">URL</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Parameters</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Status</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($smsDetails as $sms)
                <tr>
                    <td class="px-6 py-2 text-start align-middle text-nowrap w-min">{{ $sms?->brand?->name ?? 'N/A'
                        }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $sms->name }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $sms->url }}</td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $sms->parameters }}
                        </span>
                    </td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $sms->status ? $activeLabel : $inactiveLabel }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ __('No SMS details found.') }}
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>