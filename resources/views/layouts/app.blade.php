<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body class="d-flex flex-column h-100 bg-light">
    @hasSection('header')
        <header class="navbar navbar-expand-md navbar-dark bg-primary shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    @yield('header')
                </div>
            </div>
        </header>
    @endif

    <main class="">
        @yield('content')
    </main>

    <footer class="footer mt-auto py-3 bg-white border-top">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. Todos os direitos reservados.
                </div>
                <div class="col-md-6 text-center text-md-end">
                    @stack('footer-links')
                </div>
            </div>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>