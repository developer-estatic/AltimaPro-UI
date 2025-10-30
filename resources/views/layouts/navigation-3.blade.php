@php
$currentRoute = Route::currentRouteName();
@endphp

<div class="flex min-h-[calc(100vh_-_60px)]" x-data="{
    open: false,
    forceOpen: false,
    overMini: false,
    overMain: false,
    currentHasChildren: false,

    showSidebar(hasChildren) {
        this.currentHasChildren = hasChildren;
        if (hasChildren) {
            this.open = true;
        } else if (!this.forceOpen) {
            this.open = false;
        }
    },

    checkRoute() {
        this.forceOpen = true;
        this.open = true;
    },

    handleLeave() {
        setTimeout(() => {
            if (!this.overMini && !this.overMain) {
                this.open = false;
            }
        }, 250);
    }
}" x-init="checkRoute()">

    <!-- Mini Sidebar -->
    <div class="flex flex-col w-16 bg-primary/100 text-white relative" @mouseenter="overMini = true" @mouseleave="overMini = false; handleLeave()">
        <ul class="flex flex-col items-center justify-center space-y-4 py-4 px-0">
            @foreach ($menu as $item)
            @php
            $isActiveMain =
            $item->route === $currentRoute ||
            $item->children->contains(
            fn($c) => $c->route === $currentRoute || $c->children->contains('route', $currentRoute),
            );
            @endphp
            @if ($item->route && hasPermission($item->route))
            <li class="relative group" @mouseenter="showSidebar({{ $item->children->isNotEmpty() ? 'true' : 'false' }})">
                <a href="{{ $item->route ? route($item->route) : 'javascript:void(0);' }}" data-tooltip-target="tooltip-{{ $item->route }}" class="flex items-center justify-center h-12 w-12 mx-auto rounded shadow-xl {{ $isActiveMain ? 'bg-white text-primary' : 'bg-steel-blue-500/20 hover:bg-steel-blue-500/80 text-white' }}">
                    @if ($item->icon)
                    <x-dynamic-component :component="'icons.' . $item->icon" class="w-6 h-6 text-white" />
                    @endif
                </a>
                <div id="tooltip-{{ $item->route }}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white transition-opacity duration-300 bg-gray-900 rounded-lg shadow-xs opacity-0 tooltip whitespace-nowrap w-max">
                    {{ $item->name }}
                    <div class="tooltip-arrow" data-popper-arrow></div>
                </div>
            </li>
            @endif
            @endforeach
        </ul>
        <div class="fixed bottom-2 mt-0 left-2">
            <a href="javascript:void(0)" class="flex items-center justify-center h-12 w-12 mx-auto bg-steel-blue-500/20 shadow-md hover:bg-steel-blue-500/80 text-white rounded" @click="showSidebar(true)">
                <i class="fas fa-arrow-right"></i>
            </a>
            <ul class="absolute left-14 top-1 hidden group-hover:block bg-gray-800 text-white rounded shadow-lg">
                <li class="px-4 py-2">Open Sidebar</li>
            </ul>
        </div>
    </div>

    <!-- Main Sidebar -->
    <div class="relative flex flex-col min-w-48 w-max bg-gray-100/90 text-gray-900" x-show="open && currentHasChildren" x-transition:enter="transition transform duration-300" x-transition:enter-start="opacity-0 -translate-x-64" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition transform duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-64" @mouseenter="overMain = true" @mouseleave="overMain = false; handleLeave()">
        <button @click="forceOpen = false; open = false" class="absolute -top-2 right-1 p-2">
            <i class="fas fa-times"></i>
        </button>
        <ul class="space-y-4 py-4 px-1">
            @foreach ($menu as $item)
            @if ($item->children->isNotEmpty())
            @foreach ($item->children as $child)
            @php
            $hasSubChildren = $child->children->isNotEmpty();
            $isActiveChild =
            $child->route === $currentRoute || $child->children->contains('route', $currentRoute);
            $dropdownId = 'dropdown_' . $loop->parent->index . '_' . $loop->index;
            @endphp
            @if ($hasSubChildren)
            @if (!$child->route || $child->route == '' || (isset($child->route) && hasPermission($child->route)))
            <li x-data="{ isOpen_{{ $dropdownId }}: {{ $isActiveChild ? 'true' : 'false' }} }">
                <button type="button" class="flex items-center w-full p-2 text-base transition duration-75 rounded-lg group hover:bg-gray-100 {{ $isActiveChild ? 'bg-transpages! text-primary/100 font-bold' : 'text-gray-900' }}" @if ($hasSubChildren) @click="isOpen_{{ $dropdownId }} = !isOpen_{{ $dropdownId }}" @endif>

                    <span class="flex-1 me-2 @if ($hasSubChildren) text-md @endif text-left whitespace-nowrap">{{
                        $child->name }}</span>
                    @if ($hasSubChildren)
                    <svg class="w-3 h-3 transform transition-transform" :class="{ 'rotate-180': isOpen_{{ $dropdownId }} }" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                    @endif
                </button>
                @if ($hasSubChildren)
                <ul role="list" class="ms-2 ps-4! space-y-2 list-disc marker:text-gray-700" x-show="isOpen_{{ $dropdownId }}" x-transition>
                    @foreach ($child->children as $subChild)
                    @if ($subChild->route && hasPermission($subChild->route))
                    <li>
                        <a href="{{ $subChild->route ? route($subChild->route) : 'javascript:void(0);' }}" class="block p-2 rounded-lg pl-8  {{ $subChild->route === $currentRoute ? 'bg-linear-to-r from-gray-300 to-primary/100  text-white' : 'text-gray-900! hover:bg-linear-to-r from-gray-300 to-primary/100  hover:text-white!' }}">
                            {{ $subChild->name }}
                        </a>
                    </li>
                    @endif
                    @endforeach
                </ul>
                @endif
            </li>
            @endif
            @else
            @if (!$child->route || $child->route == '' || (isset($child->route) && hasPermission($child->route)))
            <li>
                <a href="{{ $child->route ? route($child->route) : 'javascript:void(0);' }}" class="block p-2 rounded-lg pl-8 {{ $child->route === $currentRoute ? 'bg-linear-to-r from-gray-300 to-primary/100  text-white' : 'text-gray-900! hover:bg-linear-to-r from-gray-300 to-primary/100  hover:text-white!' }}">
                    {{ $child->name }}
                </a>
            </li>
            @endif
            @endif
            @endforeach
            @endif
            @endforeach
        </ul>
    </div>
</div>
