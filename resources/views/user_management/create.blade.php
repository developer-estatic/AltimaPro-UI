<section>

    <div class="crm-rightsidebar-header">
        <div class="crm-rightsidebar-header-left">
            <div class="crm-rightsidebar-header-title">{{ __('Create New User') }}</div>
        </div>
        <div class="crm-rightsidebar-header-right">
            <div class="crm-rightsidebar-header-close-btn">
                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M5.02281 4.5001L6.61645 2.91017C6.68624 2.84038 6.72545 2.74573 6.72545 2.64703C6.72545 2.54834 6.68624 2.45368 6.61645 2.3839C6.54667 2.31411 6.45201 2.2749 6.35332 2.2749C6.25462 2.2749 6.15997 2.31411 6.09018 2.3839L4.50025 3.97754L2.91031 2.3839C2.84053 2.31411 2.74587 2.2749 2.64718 2.2749C2.54848 2.2749 2.45383 2.31411 2.38404 2.3839C2.31425 2.45368 2.27505 2.54834 2.27505 2.64703C2.27505 2.74573 2.31425 2.84038 2.38404 2.91017L3.97768 4.5001L2.38404 6.09004C2.3493 6.12449 2.32173 6.16548 2.30292 6.21064C2.2841 6.25581 2.27441 6.30425 2.27441 6.35317C2.27441 6.4021 2.2841 6.45054 2.30292 6.4957C2.32173 6.54087 2.3493 6.58186 2.38404 6.61631C2.41849 6.65105 2.45948 6.67862 2.50465 6.69743C2.54981 6.71625 2.59825 6.72594 2.64718 6.72594C2.6961 6.72594 2.74454 6.71625 2.78971 6.69743C2.83487 6.67862 2.87586 6.65105 2.91031 6.61631L4.50025 5.02267L6.09018 6.61631C6.12464 6.65105 6.16563 6.67862 6.21079 6.69743C6.25595 6.71625 6.30439 6.72594 6.35332 6.72594C6.40224 6.72594 6.45068 6.71625 6.49585 6.69743C6.54101 6.67862 6.582 6.65105 6.61645 6.61631C6.65119 6.58186 6.67876 6.54087 6.69758 6.4957C6.71639 6.45054 6.72608 6.4021 6.72608 6.35317C6.72608 6.30425 6.71639 6.25581 6.69758 6.21064C6.67876 6.16548 6.65119 6.12449 6.61645 6.09004L5.02281 4.5001Z" fill="#195A97" />
                </svg>
            </div>
        </div>
    </div>

    <div class="crm-rightsidebar-body form-row col-md-12">
        <div class="space-y-4">
            <form id="addUserForm" action="{{ route('users.store') }}" autocomplete="off">
                @csrf

                <div class="py-2" id="alert"></div>

                <div class="row">
                    <div class="col-md-6">
                        <x-input-label for="firstName" :value="__('First Name')" />
                        <x-text-input id="firstName" name="first_name" type="text" class="mt-1 block w-full" placeholder="First Name" required autofocus autocomplete="new-first_name" />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div class="col-md-6">
                        <x-input-label for="lastName" :value="__('Last Name')" />
                        <x-text-input id="lastName" name="last_name" type="text" class="mt-1 block w-full" placeholder="Last Name" required autofocus autocomplete="new-last_name" />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <x-input-label for="roles" :value="__('Role')" />
                        <select id="roles" name="roles" class="form-control mt-1 block w-full">
                            <option value="" selected disabled>Select Role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" placeholder="example@mail.com" required autofocus autocomplete="new-email" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" minlength="4" placeholder="* * * * * *" autocomplete="new-password" />
                        <x-input-error class="mt-2" :messages="$errors->get('password')" />
                    </div>

                    <div class="col-md-6">
                        <x-input-label for="confirmPassword" :value="__('Confirm Password')" />
                        <x-text-input id="confirmPassword" name="password" type="password" class="mt-1 block w-full" minlength="4" placeholder="* * * * * *" />
                        <x-input-error class="mt-2" :messages="$errors->get('confirm_password')" />
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <x-input-label for="country_id" :value="__('Country')" />
                        <select id="country_id" name="country_id" class="form-control mt-1 block w-full">
                            <option value="" selected disabled>Select Country</option>
                            @foreach ($countries as $country)
                                <option data-code="{{$country->country_code}}" value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" placeholder="xxxxxxxxxx" maxlength="12" required autofocus autocomplete="new-phone" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <x-input-label for="business_unit_id" :value="__('Business Unit')" />
                        <select id="business_unit_id" name="business_unit_id" class="form-control mt-1 block w-full">
                            <option value="" selected disabled>Select Business Unit</option>
                            @foreach ($businessUnits as $businessUnit)
                                <option value="{{ $businessUnit->id }}">{{ $businessUnit->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="form-control mt-1 block w-full">
                            <option value="" selected disabled>Select Status</option>
                            <option value="ACTIVE">ACTIVE</option>
                            <option value="INACTIVE">INACTIVE</option>
                            {{-- <option value="SUSPENDED">SUSPENDED</option> --}}
                        </select>
                        <x-input-error class="mt-2" :messages="$errors->first('status')" />

                        @if($errors->has('status'))
                            <span class="text-red-600 text-sm">{{ $errors->first('status') }}</span>
                        @endif

                    </div>
                </div>

                <div class="gap-4 py-5 text-center">
                    <button class="crm-green-btn w-full" type="button" id="addUser">{{ __('Submit') }}</button>
                </div>

            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>

    @vite(['resources/js/update.js'])

    <script src="{{ asset('assets/js/country_code.js') }}"></script>
</section>
