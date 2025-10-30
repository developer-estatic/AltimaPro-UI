<x-app-layout>
    <x-slot name="header">
        <div class="crm-breadcrumb-left">
        <div class="crm-breadcrumb-module-name">{{ __('Users Management') }}</div>
            <div class="crm-breadcrumb-path">
                <a href="javascript:void(0)">{{ __('Users Management') }}</a>
                <span class="crm-breadcrumb-sep-arrow">
                    <svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1154_1337)">
                            <path d="M2.79856 4.29877L0.104819 1.54866C-0.0152838 1.42611 -0.0140583 1.23002 0.10727 1.10746L0.588907 0.625827C0.712687 0.503273 0.911224 0.503273 1.03378 0.627053L4.46161 4.07695C4.52289 4.13822 4.55353 4.21788 4.55353 4.29877C4.55353 4.37966 4.52289 4.45932 4.46161 4.52059L1.03378 7.97049C0.911225 8.09427 0.712687 8.09427 0.588908 7.97171L0.10727 7.49008C-0.0140581 7.36752 -0.0152835 7.17144 0.10482 7.04888L2.79856 4.29877Z" fill="#001D3D" />
                        </g>
                        <defs>
                            <clipPath id="clip0_1154_1337">
                                <rect width="8" height="4.8" fill="white" transform="translate(0 8.5) rotate(-90)" />
                            </clipPath>
                        </defs>
                    </svg>
                </span>
                <a href="javascript:void(0)">{{ __('List') }}</a>
            </div>
        </div>
    </x-slot>

    @session('success')
    <div class="alert alert-success" role="alert">
        {{ $value }}
    </div>
    @endsession

    <!-- Main content -->
    <div class="crm-middle-content-container">
        {!! $dataTable->table([ 'class' => 'table bg-red dataTable table-bordered table-hover' ]) !!}
    </div>

    @push('scripts')
        {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
        @vite(['resources/js/datatable.js'])
    @endpush
</x-app-layout>
