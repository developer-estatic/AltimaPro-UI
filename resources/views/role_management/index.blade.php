<x-app-layout>

    <!-- Content Header (Page header) -->
    <x-slot name="header">
        <div class="crm-breadcrumb-left">
            <div class="crm-breadcrumb-module-name">{{ __('Roles Management') }}</div>
            <div class="crm-breadcrumb-path">
                <a href="javascript:void(0)">{{ __('Roles Management') }}</a>
                <span class="crm-breadcrumb-sep-arrow">
                    <svg width="5" height="9" viewBox="0 0 5 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <g clip-path="url(#clip0_1154_1337)">
                            <path
                                d="M2.79856 4.29877L0.104819 1.54866C-0.0152838 1.42611 -0.0140583 1.23002 0.10727 1.10746L0.588907 0.625827C0.712687 0.503273 0.911224 0.503273 1.03378 0.627053L4.46161 4.07695C4.52289 4.13822 4.55353 4.21788 4.55353 4.29877C4.55353 4.37966 4.52289 4.45932 4.46161 4.52059L1.03378 7.97049C0.911225 8.09427 0.712687 8.09427 0.588908 7.97171L0.10727 7.49008C-0.0140581 7.36752 -0.0152835 7.17144 0.10482 7.04888L2.79856 4.29877Z"
                                fill="#001D3D"/>
                        </g>
                        <defs>
                            <clipPath id="clip0_1154_1337">
                                <rect width="8" height="4.8" fill="white" transform="translate(0 8.5) rotate(-90)"/>
                            </clipPath>
                        </defs>
                    </svg>
                </span>
                <a href="javascript:void(0)">{{ __('List') }}</a>
            </div>
        </div>
        @can('roles.create')
            <div class="crm-breadcrumb-right">
                <div class="crm-breadcrumb-action-btns">
                    <a class="crm-green-btn" href="{{ route('roles.create') }}">{{ __('Create New Role') }}</a>
                </div>
            </div>
        @endcan
    </x-slot>

    <!-- Main content -->

    <div class="crm-middle-content-container">
        @session('success')
        <div class="alert alert-success" role="alert">
            {{ $value }}
        </div>
        @endsession

        <table class="table dataTable table-bordered table-hover no-footer">
            <tr>
                <th width="100px">{{ __('No') }}</th>
                <th>{{ __('Role') }}</th>
                <th width="280px">{{ __('Action') }}</th>
            </tr>
            @foreach ($roles as $key => $role)
                <tr>
                    <td>{{ ++$i }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @can('roles.edit')
                            <a class="" href="{{ route('roles.edit', encrypt($role->id) ) }}"><i class="fa-regular fa-pen-to-square text-gray-500 px-2"></i></a>
                        @endcan

                        @can('roles.destroy')
                            <form method="POST" action="{{ route('roles.destroy', encrypt($role->id) ) }}"
                                  style="display:inline">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="">
                                    <i class="fa-solid fa-trash text-gray-500 px-2"></i>
                                </button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

    </div>

    {!! $roles->links('pagination::bootstrap-5') !!}

    <!-- /.content -->
</x-app-layout>
