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
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">IP</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Type</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Description</th>
                    <th scope="col" class="px-6 py-2 w-min! whitespace-nowrap">Status</th>

                </tr>
            </thead>
            <tbody>
                @forelse ($whitelistedIps as $ip)
                <tr>
                    <td class="px-6 py-2 text-start align-middle text-nowrap w-min">{{ $ip?->brand?->name ?? 'N/A'
                        }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $ip->name }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $ip->ip }}</td>
                    <td class="px-6 py-2 text-start align-middle">{{ $ip->type }}</td>
                    <td class="px-6 py-2 text-start align-middle">
                        @if(strlen($ip->description) > 30)
                        <flux:tooltip content="{{ $ip->description }}" extra-classes="p-4! font-light! text-md!">
                            <span class="cursor-pointer">
                                {{ \Illuminate\Support\Str::limit($ip->description, 30, '...') }}
                            </span>
                        </flux:tooltip>
                        @else
                        {{ $ip->description }}
                        @endif
                    </td>
                    <td class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ $ip->status ? $activeLabel : $inactiveLabel }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-2 text-start align-middle">
                        <span class="text-sm font-semibold text-gray-700">
                            {{ __('No Whitelisted IPs found.') }}
                        </span>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>