@php
$activeLabel = __('Active');
$inactiveLabel = __('Inactive');
@endphp

<x-slot name="header">
    <x-partials.header title="Notifications"></x-partials.header>
</x-slot>

<div class="tabs mx-4 ms-8! min-h-[calc(100vh_-_120px)] border border-gray-200">
    <ul
        class="ps-0 mb-0 flex flex-wrap md:flex-nowrap text-sm font-medium text-center text-gray-500 rounded-lg shadow-sm ">
        <li class="w-full md:w-max! border-b md:border-0">
            <a href="#email"
                class="block w-full px-12! py-4 text-gray-900! bg-gray-100!  focus:border-b focus:border-blue-300 focus:outline-none"
                aria-current="page">Email</a>
        </li>
        <li class="w-full md:w-max! border-b md:border-0">
            <a href="#browser"
                class="block w-full px-12! py-4 text-gray-900! bg-gray-100!  focus:border-b focus:border-blue-300 focus:outline-none">Browser</a>
        </li>
        <li class="w-full md:w-max! border-b md:border-0">
            <a href="#other-app"
                class="block w-full px-12! py-4 text-gray-900! bg-gray-100!  focus:border-b focus:border-blue-300 focus:outline-none">Other
                App</a>
        </li>
    </ul>


    <div id="email" class="tab-content hidden">
        <div class="w-full min-h-[calc(40vh)] bg-gray-100/70 my-8 pt-8 rounded">
            <div class="flex flex-col space-y-8!">
                <div class="block items-center mx-4">
                    <h5 class="text-sm font-bold mb-0">
                        <span>
                            How You Get Notified
                        </span>
                    </h5>
                    <p class="text-sm text-gray-500">Please note you can't unsubscribe from important emails from your
                        account. Like Status and Billing Updated.</p>
                </div>
                <div class="border-b border-gray-200 mx-4">
                </div>
                <div class="flex flex-wrap gap-8">
                    <div class="inline-block items-center mb-1 mx-4">
                        <h5 class="text-sm font-bold mb-0">
                            <span>
                                Email
                            </span>
                        </h5>
                        <p class="text-sm text-gray-500">Email notifications will be sent to your inbox.</p>
                    </div>
                    <x-toggle :options="['Off', 'On']" :value="12" :update="'wire:model=status'" />
                </div>
            </div>
        </div>
        <div class="w-full min-h-[calc(40vh)] my-4 pt-8 rounded">
            <div class="flex flex-col space-y-8!">
                <div class="block items-center mx-4">
                    <h5 class="text-sm font-bold mb-0">
                        <span>
                            What You Get Notified About
                        </span>
                    </h5>
                    <p class="text-sm text-gray-500 mb-0">Choose what topics matter to you and how you get notified
                        about them.</p>
                </div>
                <div class="border-b border-gray-200 mx-4">
                </div>
                <div class="flex flex-wrap gap-12 mx-4">
                    <div class="inline-flex items-center mx-2">
                        <div class="flex flex-wrap items-center gap-1">
                            <input type="checkbox" id="lead" class="form-checkbox p-2.5" />
                            <label for="lead" class="text-lg font-semibold text-gray-500">Lead</label>
                        </div>
                    </div>
                    <div class="inline-flex items-center mx-2">
                        <div class="flex flex-wrap items-center gap-1">
                            <input type="checkbox" id="account" class="form-checkbox p-2.5" />
                            <label for="account" class="text-lg font-semibold text-gray-500">Account</label>
                        </div>
                    </div>
                    <div class="inline-flex items-center mx-2">
                        <div class="flex flex-wrap items-center gap-1">
                            <input type="checkbox" id="deposit" class="form-checkbox p-2.5" />
                            <label for="deposit" class="text-lg font-semibold text-gray-500">Deposit</label>
                        </div>
                    </div>
                    <div class="inline-flex items-center mx-2">
                        <div class="flex flex-wrap items-center gap-1">
                            <input type="checkbox" id="withdrawal" class="form-checkbox p-2.5" />
                            <label for="withdrawal" class="text-lg font-semibold text-gray-500">Withdrawal</label>
                        </div>
                    </div>
                    <div class="inline-flex items-center mx-2">
                        <div class="flex flex-wrap items-center gap-1">
                            <input type="checkbox" id="ib" class="form-checkbox p-2.5" />
                            <label for="ib" class="text-lg font-semibold text-gray-500">IB</label>
                        </div>
                    </div>
                    <div class="inline-flex items-center mx-2">
                        <div class="flex flex-wrap items-center gap-1">
                            <input type="checkbox" id="new_ticket" class="form-checkbox p-2.5" />
                            <label for="new_ticket" class="text-lg font-semibold text-gray-500">New Ticket</label>
                        </div>
                    </div>
                    <div class="inline-flex items-center mx-2">
                        <div class="flex flex-wrap items-center gap-1">
                            <input type="checkbox" id="bonus" class="form-checkbox p-2.5" />
                            <label for="bonus" class="text-lg font-semibold text-gray-500">Bonus</label>
                        </div>
                    </div>
                    <div class="inline-flex items-center mx-2">
                        <div class="flex flex-wrap items-center gap-1">
                            <input type="checkbox" id="emails" class="form-checkbox p-2.5" />
                            <label for="emails" class="text-lg font-semibold text-gray-500">Emails</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div id="browser" class="tab-content hidden">

    </div>
    <div id="other-app" class="tab-content hidden">
        <div class="w-full min-h-[calc(40vh)] bg-gray-100/70 my-8 pt-8 rounded">
            <div class="flex flex-col space-y-8!">
                <div class="block items-center mx-4">
                    <h5 class="text-sm font-bold mb-0">
                        <span>
                            How You Get Notified
                        </span>
                    </h5>
                    <p class="text-sm text-gray-500">Get AltimaCRM Notification In Apps, You Install and Connect.</p>
                </div>
                <div class="border-b border-gray-200 mx-4">
                </div>
                <div class="flex flex-wrap gap-1">
                    <div class="inline-block items-center mb-1 mx-4">
                        <div class="flex items-center gap-2 bg-white shadow-sm rounded-xl px-4 py-3">
                            <div class="flex items-center p-2 rounded-xl border-1">
                                <span class="text-3xl icon-[logos--microsoft-teams]"></span>
                            </div>
                            <span>Microsoft Teams</span>
                        </div>
                    </div>
                    <div class="inline-block items-center mb-1 mx-4">
                        <div class="flex items-center gap-2 bg-white shadow-sm rounded-xl px-4 py-3">
                            <div class="flex items-center p-2 rounded-xl border-1">
                                <span class="text-3xl icon-[devicon--slack]"></span>
                            </div>
                            <span>Slack</span>
                        </div>
                    </div>
                    <div class="inline-block items-center mb-1 mx-4">
                        <div class="flex items-center gap-2 bg-white shadow-sm rounded-xl px-4 py-3">
                            <div class="flex items-center p-2 rounded-xl border-1">
                                <span class="text-3xl icon-[logos--telegram]"></span>
                            </div>
                            <span>Telegram</span>
                        </div>
                    </div>
                    <div class="inline-block items-center mb-1 mx-4">
                        <div class="flex items-center gap-2 bg-white shadow-sm rounded-xl px-4 py-3">
                            <div class="flex items-center p-2 rounded-xl border-1">
                                <span class="text-3xl icon-[logos--whatsapp-icon]"></span>
                            </div>
                            <span>Whatsapp</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="relative overflow-x-auto shadow-lg sm:rounded-lg mt-4">

    <table class="w-full text-left rtl:text-right text-gray-600">

        <thead class="uppercase bg-gray-300">
            <tr class="py-8!">
                <th scope="col" class="px-6 py-3 w-80!">Name</th>
                <th scope="col" class="px-6 py-3 w-60!">Email</th>
                <th scope="col" class="px-6 py-3 w-20!">Role</th>
                <th scope="col" class="px-6 py-3 w-20!">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
            <tr class="bg-white border-b border-gray-200"
                wire:key="user-{{ $user->id }}">

                <td class="px-6 py-2 cursor-pointer">{{ $user->name }}</td>
                <td class="px-6 py-2">{{ $user->email }}</td>
                <td class="px-6 py-2">
                    {{ $user->roles->pluck('name')->join(', ') }}
                </td>
                <td class="px-6 py-2">
                    <div class="d-flex gap-2 text-xs!">
                        <flux:tooltip content="Edit" extra-classes="px-2!">
                            <flux:button variant="outline" square size="sm"
                                class=" border-1 bg-blue-700/70! text-white! rounded-md!"
                                wire:click="openModal({{ $user->id }})">
                                <i class="fas fa-edit"></i>
                            </flux:button>
                        </flux:tooltip>
                        <flux:tooltip content="Delete" extra-classes="px-2!">
                            <flux:button variant="outline" square size="sm"
                                class=" border-1 bg-red-500! text-white! rounded-md!"
                                wire:click="deleteUser({{ $user->id }})">
                                <i class="fas fa-trash"></i>
                            </flux:button>
                        </flux:tooltip>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@push('styles')
<style>
    .tabs ul li a.active {
        background-color: #f3f4f6;
        color: #111827;
        border-bottom: 1px solid var(--color-blue-300);
    }
</style>
@endpush
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.tabs ul li a');
        const contents = document.querySelectorAll('.tab-content');

        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();

                // Remove active class from all tabs and hide all content

                tabs.forEach(t => t.classList.remove('text-blue-900!', 'bg-white!', 'active'));
                tabs.forEach(t => t.classList.add('text-gray-900!', 'bg-gray-100!'));
                contents.forEach(content => content.classList.add('hidden'));

                // Add active class to the clicked tab and show its content
                tab.classList.remove('text-gray-900!', 'bg-gray-100!');
                tab.classList.add('text-blue-900!', 'bg-white!', 'active');
                const target = document.querySelector(tab.getAttribute('href'));
                if (target) {
                    target.classList.remove('hidden');
                }
            });
        });

        // Activate the #email tab and its content by default
        const defaultTab = document.querySelector('a[href="#email"]');
        const defaultContent = document.querySelector('#email');
        if (defaultTab && defaultContent) {
            defaultTab.classList.remove('text-gray-900!', 'bg-gray-100!');
            defaultTab.classList.add('text-blue-900!', 'bg-white!');
            defaultContent.classList.remove('hidden');
            defaultTab.focus();
            defaultTab.classList.add('active');
        }
    });
</script>
@endpush