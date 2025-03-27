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

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Livewire Styles -->
    @livewireStyles
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-cover bg-center bg-fixed"
        style="background-image: url('/storage/fondos/Fondo3.jpg');">
        <div>
            <a href="/">
                <img src="{{ asset('storage/logo/Forza64_2.png') }}" alt="Forza Training Center Logo"
                    class="h-20 w-auto">
            </a>
        </div>

        <!-- Modifico el div del slot para que el ancho no sea fijo y se adapte al register o al login -->
        <div>
            {{ $slot }}
        </div>
    </div>
    <!-- Livewire Scripts -->
    @livewireScripts
</body>

</html>
