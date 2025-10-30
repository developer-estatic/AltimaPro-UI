<section>

    <div class="crm-rightsidebar-header">
        <div class="crm-rightsidebar-header-left">
            <div class="crm-rightsidebar-header-title">{{ __('Update Profile') }}</div>
            <div class="crm-rightsidebar-header-text">{{ __('Update your profile information.') }}</div>
        </div>
        <div class="crm-rightsidebar-header-right">
            <div class="crm-rightsidebar-header-close-btn">
                <svg width="9" height="9" viewBox="0 0 9 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M5.02281 4.5001L6.61645 2.91017C6.68624 2.84038 6.72545 2.74573 6.72545 2.64703C6.72545 2.54834 6.68624 2.45368 6.61645 2.3839C6.54667 2.31411 6.45201 2.2749 6.35332 2.2749C6.25462 2.2749 6.15997 2.31411 6.09018 2.3839L4.50025 3.97754L2.91031 2.3839C2.84053 2.31411 2.74587 2.2749 2.64718 2.2749C2.54848 2.2749 2.45383 2.31411 2.38404 2.3839C2.31425 2.45368 2.27505 2.54834 2.27505 2.64703C2.27505 2.74573 2.31425 2.84038 2.38404 2.91017L3.97768 4.5001L2.38404 6.09004C2.3493 6.12449 2.32173 6.16548 2.30292 6.21064C2.2841 6.25581 2.27441 6.30425 2.27441 6.35317C2.27441 6.4021 2.2841 6.45054 2.30292 6.4957C2.32173 6.54087 2.3493 6.58186 2.38404 6.61631C2.41849 6.65105 2.45948 6.67862 2.50465 6.69743C2.54981 6.71625 2.59825 6.72594 2.64718 6.72594C2.6961 6.72594 2.74454 6.71625 2.78971 6.69743C2.83487 6.67862 2.87586 6.65105 2.91031 6.61631L4.50025 5.02267L6.09018 6.61631C6.12464 6.65105 6.16563 6.67862 6.21079 6.69743C6.25595 6.71625 6.30439 6.72594 6.35332 6.72594C6.40224 6.72594 6.45068 6.71625 6.49585 6.69743C6.54101 6.67862 6.582 6.65105 6.61645 6.61631C6.65119 6.58186 6.67876 6.54087 6.69758 6.4957C6.71639 6.45054 6.72608 6.4021 6.72608 6.35317C6.72608 6.30425 6.71639 6.25581 6.69758 6.21064C6.67876 6.16548 6.65119 6.12449 6.61645 6.09004L5.02281 4.5001Z"
                        fill="#195A97" />
                </svg>
            </div>
        </div>
    </div>

    <div class="crm-rightsidebar-body form-row col-md-12">
        <div class="mt-2 space-y-6">
            <form id="updateProfileForm" action="{{ route('profile.update') }}">
                @csrf

                <div class="py-2" id="alert"></div>

                <div class="row">
                    <div class="col-md-6">
                        <x-input-label for="firstName" :value="__('First Name')" />
                        <x-text-input id="firstName" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', Auth::user()->first_name)" required autofocus autocomplete="first_name" />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>

                    <div class="col-md-6">
                        <x-input-label for="lastName" :value="__('Last Name')" />
                        <x-text-input id="lastName" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', Auth::user()->last_name)" required autofocus autocomplete="last_name" />
                        <x-input-label class="mt-2 error first-name" />
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="old('email', Auth::user()->email)" readonly required autofocus autocomplete="email" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div class="col-md-6">
                        <x-input-label for="phone" :value="__('Phone')" class="mb-1" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', Auth::user()->phone)" required autofocus autocomplete="phone" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                </div>

                <div class="row mt-2">
                    <div class="col-md-6">
                        <div class="mx-auto mt-1 shadow-sm">
                            <x-input-label for="avatar" :value="__('Avatar')" />
                            <x-text-input id="avatar" name="avatar" type="file" :value="old('avatar', Auth::user()->avatar)" required autofocus autocomplete="avatar" class="w-full text-gray-900 border file:cursor-pointer cursor-pointer file:border-0 file:py-2 file:px-4 file:mr-4 file:bg-gray-300 file:hover:bg-gray-200 file:text-gray-700 rounded" />
                            <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
                        </div>
                    </div>
                </div>

                <div class="gap-4 py-5 text-center d-flex">
                    <a class="crm-gray-btn crm-show-right-side-bar w-full" href="#" data-type="view-profile">{{ __('Back') }}</a>
                    <button class="crm-green-btn w-full" type="button" id="updateProfile">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
    @vite(['resources/js/update.js'])

    <script src="{{ asset('assets/js/country_code.js') }}"></script>
</section>
