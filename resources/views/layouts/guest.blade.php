<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/css/style.css', 'resources/js/app.js'])

</head>
<body class="font-sans crm-login-bg antialiased">
<div class="min-h-screen items-center pt-6 sm:pt-0">
    <div class="row crm-login-wrapper align-items-center min-vh-100 min-vw-100 w-100">
        <div class="col-md-6 offset-md-1">
            <div id="loginCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="bullets carousel-indicators">
                    <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#loginCarousel" data-bs-slide-to="4" aria-label="Slide 4"></button>
                </div>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{ asset('img/slides/1.png') }}" class="d-block w-100" alt="slide 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="h2 text-black">Easy to Manage Clients &amp;Accounts</h2>
                            <h4 class="text-black">Add/Import Contacts, Add MT4 Accounts Online Verification.</h4>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/slides/2.png') }}" class="d-block w-100" alt="slide 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="h2 text-black">Designed for Monitoring & Manage Tasks</h2>
                            <h4 class="text-black">Track status, reminders, notes, emails, followup, deposits, withdraws.</h4>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="{{ asset('img/slides/3.png') }}" class="d-block w-100" alt="slide 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="h2 text-black mt-5">Focus on sales strategies</h2>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="carousel-caption d-none d-md-block">
                            <h2 class="h2 text-black">Efficiently Manage BU, Groups & Teams</h2>
                            <h4 class="text-black">Roles, Rights, Permissions.</h4>
                        </div>
                        <img src="{{ asset('img/slides/4.png') }}" class="d-block w-100" alt="slide 4">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 offset-md-1">
            <div class="row">
                <div class="col-7">
                    <a href="/">
                        <x-application-logo/>
                    </a>
                </div>
                <div class="col-4 offset-1">
                    <form id="langform" action="{{ route('language') }}" method="get" class="float-end">
                        <select class="form-select-sm border-0 mt-3" name="lang" id="lang" onchange="this.form.submit()">
                            <option disabled>Language</option>
                            <option value="en" @if (Session::get('locale', 'en') == 'en') selected @endif>EN</option>
                            <option value="fr" @if (session('locale') == 'fr') selected @endif>FR</option>
                            <option value="pt" @if (session('locale') == 'pt') selected @endif>PT</option>
                            <option value="ar" @if (session('locale') == 'ar') selected @endif>AR</option>
                            <option value="it" @if (session('locale') == 'it') selected @endif>IT</option>
                        </select>
                    </form>
                </div>
            </div>

            <div class="w-full mt-2 px-10 py-10 bg-gray-50 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
