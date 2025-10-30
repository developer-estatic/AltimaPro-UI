<div class="flex min-h-screen" x-data="{ open: true, miniOpen: true }">
    <!-- Small Sidebar -->
    <div class="flex flex-col w-16 bg-primary/100 text-white relative" x-show="miniOpen" x-transition:enter="transition transform duration-300" x-transition:enter-start="opacity-0 -translate-x-16" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition transform duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-16">
        <ul class="relative space-y-4 py-4 px-0">
            <li class="relative group ">
                <a href="/brands" wire:navigate class="flex items-center justify-center h-12 w-12 mx-auto bg-steel-blue-500/20 shadow-md hover:bg-steel-blue-500/80 text-white rounded">
                    <i class="fas fa-building"></i>
                </a>
                <ul class="absolute left-14 top-1 hidden group-hover:block bg-gray-800 text-white rounded shadow-lg">
                    <li class="px-4 py-2" x-show="!open">Brands</li>
                </ul>
            </li>
            <li class="relative group">
                <a href="/voips" wire:navigate class="flex items-center justify-center h-12 w-12 mx-auto bg-steel-blue-500/20 shadow-md hover:bg-steel-blue-500/80 text-white rounded">
                    <i class="fas fa-phone"></i>
                </a>
                <ul class="absolute left-14 top-1 hidden group-hover:block bg-gray-800 text-white rounded shadow-lg">
                    <li class="px-4 py-2" x-show="!open">VoIPs</li>
                </ul>
            </li>
            <li class="relative group">
                <a href="/roles" wire:navigate class="flex items-center justify-center h-12 w-12 mx-auto bg-steel-blue-500/20 shadow-md hover:bg-steel-blue-500/80 text-white rounded">
                    <i class="fas fa-user-shield"></i>
                </a>
                <ul class="absolute left-14 top-1 hidden group-hover:block bg-gray-800 text-white rounded shadow-lg">
                    <li class="px-4 py-2" x-show="!open">Roles</li>
                </ul>
            </li>
        </ul>
        <div class="absolute bottom-12 left-0 right-0">
            <a href="javascript:void(0)" class="flex items-center justify-center h-12 w-12 mx-auto bg-steel-blue-500/20 shadow-md hover:bg-steel-blue-500/80 text-white rounded" @click="open = true">
                <i class="fas fa-arrow-right"></i>
            </a>
            <ul class="absolute left-14 top-1 hidden group-hover:block bg-gray-800 text-white rounded shadow-lg">
                <li class="px-4 py-2">Open Sidebar</li>
            </ul>
        </div>
    </div>

    <!-- Main Sidebar -->
    <div class="relative flex flex-col w-48 bg-gray-100/90 text-gray-900" x-show="open" x-transition:enter="transition transform duration-300" x-transition:enter-start="opacity-0 -translate-x-64" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition transform duration-300" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 -translate-x-64" style="display: none;">
        <button @click="open = false" class="absolute top-1 right-1 p-2">
            <span>x</span>
        </button>
        <ul class="space-y-4 py-4 px-1">
            <li>
                <a href="/brands" class="block px-4 py-2 hover:bg-gray-200 rounded">Brands</a>
            </li>
            <li>
                <a href="/voips" class="block px-4 py-2 hover:bg-gray-200 rounded">VoIPs</a>
            </li>
            <li>
                <a href="/roles" class="block px-4 py-2 hover:bg-gray-200 rounded">Roles</a>
            </li>
            <!-- Add more links for other sections as needed -->
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1 bg-white">
        <!-- Content goes here -->
    </div>
</div>