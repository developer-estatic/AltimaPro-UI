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
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Extension</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Secret Key</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Status</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($voipDetails as $voip)
                <tr>
                    <td class="px-6 py-2 text-start align-middle text-nowrap w-min">{{ $voip?->brand?->name ?? 'N/A'
                        }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $voip->name }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $voip->url }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $voip->extension }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $voip->secret_key }}</td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $voip->status ? $activeLabel : $inactiveLabel }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ __('No VoIP details found.') }}
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>