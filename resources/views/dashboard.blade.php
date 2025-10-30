<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('Dashboard') }}
            <small>{{ __('Control panel') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> {{ __('Dashboard') }}</li>
        </ol>
    </x-slot>

    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">{{ __("Welcome to Altima CRM") }}</h3>
                </div>
                <div class="box-body">
                    {{ __("Welcome") }}
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
