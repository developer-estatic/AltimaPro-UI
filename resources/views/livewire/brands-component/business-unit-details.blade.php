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
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Is Parent</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Status</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Timezone</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Language</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">FTD Amount</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Partial FTD</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">S3 Bucket Name</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">S3 Bucket Path</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Is Pamm</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Is Social</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Is Prop</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($business_units as $unit)
                <tr>
                    <td class="px-6 py-2 text-start align-middle text-nowrap w-min">{{ $unit?->brand?->name ?? 'N/A'
                        }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $unit->name }}</td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $unit->is_parent ? 'Yes' : 'No' }}
                        </span>
                    <td class="px-6 py-2 text-start align-middle">{{ $unit->status ? $activeLabel : $inactiveLabel
                        }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $unit->timezone }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $unit->language }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $unit->ftd_amount }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $unit->partial_ftd }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $unit->s3_bucket_name }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $unit->s3_bucket_path }}</td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $unit->is_pamm ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $unit->is_social ? 'Yes' : 'No' }}
                        </span>
                    </td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $unit->is_prop ? 'Yes' : 'No' }}
                        </span>
                    </td>


                </tr>
                @empty
                <tr>
                    <td colspan="13" class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ __('No Business Unit details found.') }}
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>