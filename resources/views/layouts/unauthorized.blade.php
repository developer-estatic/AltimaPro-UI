<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/css/intlTelInput.css">
        <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" />

        <!-- Scripts -->
        @vite([
            'resources/css/style.css',
            'resources/sass/app.scss',
            'resources/css/app.css',
            'resources/js/head.js',
            'resources/js/app.js'
        ])
    </head>
    <body>
        {{-- <button id="toast" type="button"  class="d-none fixed right-4 top-4 z-50 rounded-md bg-green-400 px-4 py-2 text-white transition hover:bg-green-600">
            <div class="flex items-center space-x-2">
                <span class="text-3xl"><i class="bx bx-check"></i></span>
                <p id="msg" class="font-bold"></p>
            </div>
        </button> --}}

        <div class="crm-main-wrapper">
            <div class="crm-main-container min-h-[calc(100vh)]">

                @include('layouts.header')
                <div class="flex relative">
                    @include('layouts.navigation')

                <!-- Page Heading -->
                {{-- @isset($header)
                    <header class="crm-breadcrumb">
                        {{ $header }}
                    </header>
                @endisset --}}

                <!-- Page Content -->
                <main class="crm-middle-content-wrapper">
                    {{ $slot }}
                </main>
                </div>

                <!-- RightSidebar Block Starts-->
                <div class="crm-rightsidebar-wrapper"> <!-- crm-show-rightsidebar -->
                    @include('layouts.right-bar')
                </div>
                <!-- RightSidebar Block Ends-->

            </div>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/intl-tel-input@24.5.0/build/js/intlTelInput.min.js"></script>

        <script src="{{ asset('assets/js/util.js') }}"></script>

        @stack('scripts')
    </body>
</html>
