<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Forza Training Center</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-image: url('{{ asset('storage/fondos/fondo3.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">

    <header class="bg-opacity-80 bg-gray-800 p-4">
        <nav class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <img src="{{ asset('storage/logo/Forza64_2.png') }}" alt="Forza Training Center Logo"
                    class="h-12 w-auto">
                <span class="text-2xl font-bold ml-4">
                    <span class="text-red-500">Forza</span> <span class="text-white">Training Center</span>
                </span>
            </div>
            {{-- Enlaces del Navbar --}}
            <div>
                @if (Route::has('login'))
                    <div class="space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}"
                                class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}"
                                class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="text-white bg-gray-600 hover:bg-gray-700 px-4 py-2 rounded-md">Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
            </div>
        </nav>
    </header>

    <!-- Contenido principal -->
    <main class="flex-grow">
        <!-- Sección de Bienvenida - Reducida para evitar scroll -->
        <div class="flex items-center justify-center h-64"> <!-- Reducido de h-96 a h-64 -->
            <div class="text-center p-8 bg-black bg-opacity-50 rounded-lg shadow-2xl">
                <h1 class="text-5xl font-bold mb-4">
                    <span class="text-red-500">Forza</span> <span class="text-white">Training Center</span>
                </h1>
                <p class="text-xl text-white">¡Bienvenidos!</p>
            </div>
        </div>

        <!-- Sección de Actividades - Reducido padding vertical para evitar scroll -->
        <div class="bg-white bg-opacity-60 py-6"> <!-- Reducido de py-8 a py-6 -->
            <div class="max-w-[90%] mx-auto px-4">
                <h2 class="text-3xl font-bold text-center mb-4">
                    <span class="text-red-500">Nuestras</span> Actividades
                </h2>

                <!-- Componente de tarjetas de actividades -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @if (isset($activities))
                        @foreach ($activities as $activity)
                            <x-activity-card :activity="$activity" :showReservationButton="true" />
                        @endforeach
                    @else
                        <div class="col-span-4 text-center">
                            <p class="text-red-500 bg-white p-4 rounded shadow">No hay actividades disponibles en este
                                momento.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</body>

</html>
