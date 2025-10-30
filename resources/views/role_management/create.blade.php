<x-app-layout>

    <!-- Content Header (Page header) -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles Management') }}
        </h2>
    </x-slot>

    <div class="crm-middle-content-container">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br>
                    </div>
                @endif
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <form method="POST" action="{{ route('roles.store') }}">
                                @csrf
                                <div class="card-header">
                                    {{ __('Create Role') }}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>{{ __('Role Name') }}:</strong>
                                                <input type="text" name="name" placeholder="{{ __('Name') }}"
                                                       value="{{ old('name') }}"
                                                       class="form-control">
                                                @error('name')
                                                <div id="validationServer03Feedback" class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-12 col-md-6">
                                            <div class="form-group">
                                                <strong>{{ __('Parent Role') }}:</strong>
                                                <select name="parent_id" class="form-control">
                                                    <option value="">{{ __('Choose a parent') }}</option>
                                                    @foreach($roles as $row)
                                                        <option
                                                            value="{{ $row->id }}" {{ $row->id == old('parent_id') ? 'selected' : '' }}>{{ $row->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('parent_id')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-header border-top">
                                    {{ __('Permissions') }}
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                @foreach($modules as $module)
                                                    <h3 class="w-100 font-bold text-blue-800">{{ __($module->name) }}</h3>
                                                    <div class="row">
                                                        @foreach($module->permissions as $permission)
                                                            <div class="col-md-3 py-2 mb-3">
                                                                <input type="checkbox"
                                                                       name="permission[{{$permission->id}}]"
                                                                       value="{{ $permission->id }}"
                                                                       @if(old('permission') != null)
                                                                           {{ in_array($permission->id, old('permission')) ? 'checked' : '' }}
                                                                       @endif class="name">
                                                                {{ __($permission->display_name) }}
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer text-end">
                                    <a href="{{ route('roles.index') }}" class="btn btn-danger">{{ __('Cancel') }}</a>
                                    <button type="submit" class="btn btn-primary">{{ __("Submit") }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>


            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


</x-app-layout>

