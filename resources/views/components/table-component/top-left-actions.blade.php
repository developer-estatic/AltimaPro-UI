<div class="flex gap-2">
    <button class="px-2 py-1 bg-white text-blue-900 rounded-sm border border-mercury">
        <flux:icon.funnel variant="solid" class="size-4" />
    </button>
    <div class="flex gap-0">
        <button class="px-2 py-1 bg-solitude-100 text-dark rounded-l-sm flex items-center gap-1 text-endeavour hover:!border hover:!border-red-700">
            {{-- <flux:icon.users variant="outline" class="size-4 text-endeavour" /> --}}
            <span class="icon-[tabler--users-group] text-lg text-picton-blue-500"></span>
            <span class="text-picton-blue-500 text-sm/6">
                Assign
            </span>
        </button>
        <button class="flex items-center gap-1 px-2 py-1 border-l border-gray-950 bg-solitude-100 text-dark hover:!border hover:!border-red-700">
            <x-zondicon-shuffle class="font-light w-4 h-4 text-black" />
            <span class="text-black text-sm/6">
                Change Status
            </span>
        </button>
        <button class="flex items-center gap-1 px-2 py-1 border-l border-gray-950 bg-solitude-100 text-dark hover:!border hover:!border-red-700">
            <span class="icon-[gg--notes] text-sm text-black"></span>
            <span class="text-black text-sm/6 ">
                Notes
            </span>
        </button>
        <button class="flex items-center gap-1 px-2 py-1 border-l border-gray-950 bg-solitude-100 text-dark hover:!border hover:!border-red-700">
            <span class="icon-[ph--clock-clockwise] text-lg font-extrabold text-black"></span>
            <span class="text-black text-sm/6 ">
                Reminder
            </span>
        </button>
        <button class="flex items-center gap-1 px-2 py-1 border-l border-gray-950 bg-solitude-100 text-dark hover:!border hover:!border-red-700">
            <span class="icon-[ic--outline-email] text-lg text-black"></span>
            <span class="text-black text-sm/6 ">
                Email
            </span>
        </button>
        <button class="flex items-center gap-1 px-2 py-1 border-l border-gray-950 bg-solitude-100 text-dark rounded-r-sm hover:!border hover:!border-red-700">
            <span class="icon-[iconamoon--trash-light] text-lg text-black"></span>
            <span class="text-black text-sm/6 ">
                Delete
            </span>
        </button>

    </div>
</div>