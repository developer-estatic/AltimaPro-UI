@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-app-layout>
    <x-slot name="header">
        <x-partials.header title="Brands"></x-partials.header>
    </x-slot>

<section class="content border clearfix cmn-tabe cmn-newtab ml-15 mr-15">
    <!-- tabs design -->
    <div class="fund-top nav-tabs-custom">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs tabs-left">
            <li class="active my_tab1"><a href="#profile" data-toggle="tab" aria-expanded="true">Profile</a></li>
            <li class="my_tab2"><a href="#email" data-toggle="tab" aria-expanded="false">Email</a></li>
            <li class="my_tab3"><a href="#calling-voip" data-toggle="tab" aria-expanded="false">Calling/Voip</a></li>
            <li class="my_tab4"><a href="#security" data-toggle="tab" aria-expanded="false">Security</a></li>
        </ul>
    </div>
    
    <div class="fund-body listingpg">
        <!-- Tab panes -->
        <div class="tab-content border p-15">
            <div class="tab-pane active" id="profile">
        <div class="block items-center mb-1 mx-4">
            <h6 class="text-sm font-bold mb-0">
                <span>
                    Global
                </span>
            </h6>
        </div>
        <div class="flex flex-col">
            <div>
                <div
                    class="flex flex-wrap md:flex-nowrap items-center justify-center md:justify-start mt-8 mb-1 mx-4 gap-16">
                    <x-file-input :initials="makeInitials($first_name.' '.$last_name)" model="avatar"
                        :avatar="$avatar" />
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-x-8 gap-y-12">
                        <div class="flex items-center">
                            <x-form.input id="first_name" label="First Name" type="text" model="first_name" required
                                placeholder="John" />
                        </div>
                        <div class="flex items-center">
                            <x-form.input id="last_name" label="Last Name" type="text" model="last_name" required
                                placeholder="Doe" />
                        </div>
                        <div class="flex items-center">
                            <x-form.input id="language" label="Language" type="text" model="language" required
                                placeholder="English" />
                        </div>
                        <div class="flex items-center">
                            <x-form.input id="date_time_number_format" label="Date Time Number Format" type="text"
                                model="date_time_format" required placeholder="MM/DD/YYYY" />
                        </div>
                        <div class="flex items-center">
                            <x-form.input id="phone_number" label="Phone Number" type="text" model="phone" required
                                placeholder="+1234567890" />
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-start mt-8 mb-1 mx-4 gap-16">
                    <div></div>
                    <div></div>
                    <flux:button wire:click="saveProfile" variant="primary" type="button" class="rounded mt-3 hover:bg-persian-green">Save
                    </flux:button>
                </div>

            </div>
            <div class="mt-8 bg-gray-200/70 h-full">
                <div class="block items-center mb-1 mx-4 py-4">
                    <h5 class="text-sm font-bold mb-0">
                        <span>
                            Defaults
                            <br>
                            <small class="text-gray-500">
                                <small>
                                    <small>
                                        This only applies to AltimaCRM Account
                                    </small>
                                </small>
                            </small>
                        </span>
                    </h5>
                </div>
                <div class="block items-center mb-1 mx-4 py-4">
                    <x-form.input id="default_home_page" label="Default Home Page" type="text" model="default_home_page"
                        required class="bg-transparent! w-80! border-b-gray-300" placeholder="" />
                    <br>
                    <flux:button wire:click="saveDefaultHomePage" variant="primary" size="sm" type="button"
                        class="rounded mx-0 mt-2 hover:bg-persian-green">Save</flux:button>
                </div>
            </div>
        </div>
            </div>
            <!-- End Profile Tab -->


            <div class="tab-pane" id="email" x-data="{ showModal: false }">
        <div class="w-full min-h-[calc(80vh)] bg-gray-100/70 pt-8">
            <div class="block items-center mb-1 mx-4">
                <h5 class="text-sm font-bold mb-0">
                    <span>
                        Configure
                    </span>
                </h5>
            </div>
            <div class="block items-center my-12 mx-4">
                <button
                    class="px-4 py-2 text-sm shadow-md font-medium text-white bg-persian-green border border-persian-green-10 rounded hover:bg-persian-green-10 hover:border-persian-green-10 focus:outline-none focus:ring-2 focus:ring-persian-green-30"
                    type="button" @click="$dispatch('open-modal', 'email-alias-modal')">
                    <span class="flex items-center">
                        <span class="text-sm">Add Email Alias</span>
                    </span>
                </button>
                <br>
                <span class="text-sm font-light text-gray-500 dark:text-gray-400">An email alias allows emails sent
                    outside of altimacrn to be associated with your user. <a href="javascript:void(0)"
                        class="text-blue-500 hover:underline">Learn more</a></span>
            </div>
            <div class="block items-center my-12 mx-4">
                <button
                    class="px-4 py-2 text-sm shadow-md font-medium text-white bg-persian-green border border-persian-green-10 rounded hover:bg-persian-green-10 hover:border-persian-green-10 focus:outline-none focus:ring-2 focus:ring-persian-green-30"
                    type="button">
                    <span class="flex items-center">
                        <span class="text-sm">Edit Email Signature</span>
                    </span>
                </button>
                <br>
                <span class="text-sm font-light text-gray-500 dark:text-gray-400">Your signature will be used on
                    one-on-one emails through the AltimaCRM and as a personalization token for marketing emials
                    <br>Include Unsubscribe Link Recommended. <a href="javascript:void(0)"
                        class="text-blue-500 hover:underline">Learn more</a></span>
            </div>

            <x-modal name="email-alias-modal" class="top-[calc(100vh-70%)]" maxWidth="md">
                <div
                    class="flex items-center justify-between p-3 md:p-5 border-b rounded-t border-gray-200 bg-blue-200">
                    <h5 class="font-semibold text-gray-900 mb-0">
                        Add an email
                    </h5>
                </div>
                <div class="p-4 font-light text-sm">
                    This email will be able to log emails to the CRM using the BCC and forwarding addresses. <br>
                </div>
                <div class="p-4">
                    <x-form.input id="email_alias" label="Add an Email Address" type="text" model="email_alias" required
                        placeholder="Add an Email Address" />
                </div>
                <div class="p-4 flex justify-start">
                    <flux:button type="button" variant="primary" class="rounded hover:bg-persian-green">Submit</flux:button>
                    <flux:button @click="$dispatch('close-modal', 'email-alias-modal')" variant="subtle">Cancel
                    </flux:button>
                </div>
                {{-- <form wire:submit.prevent="saveMenuAccess"></form> --}}
            </x-modal>


        </div>
            </div>
            <!-- End Email Tab -->
            
            <div class="tab-pane" id="calling-voip">
                <p>Calling/VoIP content goes here.</p>
            </div>
            <!-- End Calling/Voip Tab -->
            
            <div class="tab-pane" id="security">
        <div class="w-full min-h-[calc(40vh)] bg-gray-100/70 my-8 pt-8 rounded">
            <div class="block items-center mb-1 mx-4">
                <h5 class="text-sm font-bold mb-0">
                    <span>
                        Security
                    </span>
                </h5>
                <p class="text-sm text-gray-500">Set Preferences Related To Login And Your Personal Account Security.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:md:grid-cols-4 gap-3 mx-4 mt-6">
                <div class="p-4 ">
                    <h6 class="text-sm font-bold mb-0">Email Address</h6>
                    <div class="flex" x-data="{ readonly: true }">
                        <x-form.input id="user_email_address" label="" type="text" class="bg-transparent" model="email"
                            x-bind:readonly="readonly" />
                        <div class="flex items-center gap-2">

                            <button x-show="readonly" @click="readonly = !readonly"><i
                                    class="fas fa-pen-to-square text-gray-500"></i></button>
                            <button x-show="!readonly" wire:click="updateUserEmail"><i
                                    class="fa-solid fa-floppy-disk text-green-500 text-xl"></i></button>
                            <button x-show="!readonly" @click="readonly = !readonly"><i
                                    class="fa-solid fa-xmark text-red-500 text-2xl"></i></button>
                        </div>
                    </div>
                </div>
                <div class="p-4 ">
                    <h6 class="text-sm font-bold">Passwords</h6>
                    <a href="javascript:void(0)" class="text-persian-green/80! underline!"
                        @click="$dispatch('open-modal', 'reset-password-modal')">Reset Password</a>
                    <p class="text-xs text-gray-500 mb-0 mt-1">Last Reset On 14/12/2023</p>
                </div>
                <div class="p-4 lg:col-span-2">
                    <h6 class="text-sm font-bold">Trusted Phone Number</h6>
                    @if ($phone)
                        <p class="text-lg text-gray-700">
                            {{ $phone }}
                            <i @click="$dispatch('open-modal', 'update-phone-modal')" class="text-md ms-2 fas fa-pen-to-square cursor-pointer text-gray-500"></i>
                        </p>
                    @else
                        <a href="javascript:void(0)" class="text-persian-green/80! underline!" @click="$dispatch('open-modal', 'update-phone-modal')">Add A Trusted Phone Number</a>
                    @endif
                    <p class="text-xs text-gray-500 mb-0 mt-1">Add A Phone Number Used To Occasionally Verify Your Identity And Receive Other Security-Related Alerts. This Phone Number Will Never Be Used For Sales Or Marketing Purposes.</p>
                </div>
            </div>
        </div>
        <div class="w-full min-h-[calc(30vh)] bg-transparent">

            <div class="grid grid-cols-1 gap-4 mx-4 mt-6">
                <div class="p-1">
                    <a href="javascript:void(0)" class="text-persian-green/80! hover:underline">Log Out Of All
                        Sessions</a>
                    <p class="text-xs text-gray-500 mb-1 mt-1">This Will Log You Out Of All Devices And Sessions,
                        Including
                        This Active One.</p>
                </div>
                <div class="p-1">
                    <a href="javascript:void(0)" class="text-persian-green/80! hover:underline">Remove Me From This
                        Account</a>
                    <p class="text-xs text-gray-500 mb-1 mt-1">This Action Will Remove Your User From This Account. If
                        You're
                        Part Of Other Accounts, You'll Still Have Access To Them.</p>
                </div>
                <div class="p-1">
                    <a href="javascript:void(0)" class="text-persian-green/80! hover:underline">Delete My User
                        Account</a>
                    <p class="text-xs text-gray-500 mb-1 mt-1">This Action Will Permanently Delete Your User Account.
                    </p>
                </div>
            </div>
        </div>
            </div>
            <!-- End Security Tab -->
            
        </div>
        <!-- End tab-content -->
    </div>
    <!-- End fund-body -->
</section>
<!-- End section -->

    <x-modal name="reset-password-modal" class="top-[calc(100vh-90%)]" maxWidth="md">
        <div class="flex items-center justify-between p-3 md:p-5 border-b rounded-t border-gray-200 bg-blue-200">
            <h5 class="font-semibold text-gray-900 mb-0">
                Reset Password
            </h5>
        </div>
        <div class="p-4 pb-0 font-light text-sm">
            Please enter your current password and new password to reset.
        </div>
        <div class="flex flex-col gap-8 px-4">
            <div class="relative" x-data="{ show: false }">
                <x-form.input id="current_password" x-bind:type="show ? 'text' : 'password'"
                    model="current_password" placeholder="Enter your current password" />
                <button type="button" class="absolute inset-y-0 end-0 flex items-center px-2" @click="show = !show">
                    <flux:icon.eye x-show="!show" />
                    <flux:icon.eye-slash x-show="show" />
                </button>
            </div>
            <div class="relative" x-data="{ show: false }">
                <x-form.input id="new_password" x-bind:type="show ? 'text' : 'password'" model="new_password"
                    placeholder="Enter your new password" />
                <button type="button" class="absolute inset-y-0 end-0 flex items-center px-2" @click="show = !show">
                    <flux:icon.eye x-show="!show" />
                    <flux:icon.eye-slash x-show="show" />
                </button>
            </div>
            <div class="relative" x-data="{ show: false }">
                <x-form.input id="new_password_confirmation" x-bind:type="show ? 'text' : 'password'"
                    model="new_password_confirmation" placeholder="Confirm your new password" />
                <button type="button" class="absolute inset-y-0 end-0 flex items-center px-2" @click="show = !show">
                    <flux:icon.eye x-show="!show" />
                    <flux:icon.eye-slash x-show="show" />
                </button>
            </div>
        </div>
        <div class="p-4 flex justify-start mt-6">
            <flux:button wire:click="resetPassword" type="button" variant="primary" class="rounded hover:bg-persian-green!">Update Password</flux:button>
            <flux:button @click="$dispatch('close-modal', 'reset-password-modal')" variant="subtle">Cancel</flux:button>
        </div>
    </x-modal>

    <x-modal name="update-phone-modal" class="top-[calc(100vh-70%)]" maxWidth="md">
        <div class="flex items-center justify-between p-3 md:p-5 border-b rounded-t border-gray-200 bg-blue-200">
            <h5 class="font-semibold text-gray-900 mb-0">
                Update Phone Number
            </h5>
        </div>
        <div class="p-4 font-light text-sm">
            Please enter your phone number to update.
        </div>
        <div class="p-4">
            <x-form.input id="phone" label="Phone Number" type="text" model="phone" required placeholder="Enter your phone number" />
        </div>
        <div class="p-4 flex justify-start">
            <flux:button wire:click="updatePhoneNumber" type="button" variant="primary" class="rounded hover:bg-persian-green">Submit</flux:button>
            <flux:button @click="$dispatch('close-modal', 'update-phone-modal')" variant="subtle">Cancel</flux:button>
        </div>
    </x-modal>
</x-app-layout>
