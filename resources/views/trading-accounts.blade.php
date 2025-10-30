<x-app-layout>
    <x-slot name="header">
        <h1>
            {{ __('Trading Accounts') }}
            <small>{{ __('Manage trading accounts') }}</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ __('Home') }}</a></li>
            <li class="active">{{ __('Trading Accounts') }}</li>
        </ol>
    </x-slot>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">{{ __('All Trading Accounts') }}</h3>
            <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div>
        </div>
        <div class="box-body">
            <div x-data="{
                showLivewireComponent: true,
                onReloadComponent() {
                    this.showLivewireComponent = false;
                    setTimeout(() => {
                        this.showLivewireComponent = true;
                    }, 1);
                }
            }">
                <span @reload-livewire-component.window="onReloadComponent()"></span>
                <template x-if="showLivewireComponent">
                    <livewire:dynamic-datatable :table="$table" :table-head-columns-and-data-keys="$tableHeadColumnsAndDataKeys" :conditions="$conditions" />
                </template>
            </div>
        </div>
    </div>

</x-app-layout>
