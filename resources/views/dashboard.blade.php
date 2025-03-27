<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-white leading-tight">
                @if (Auth::user()->role === 'ADMIN')
                    Admin Area
                @else
                    User Area
                @endif
            </h2>
            {{-- <h2 class="text-xl font-extrabold text-white">
                Bienvenido, {{ Auth::user()->name }}.
            </h2> --}}
        </div>
    </x-slot>

    <div class="py-8">
        @if (Auth::user()->role === 'ADMIN')
            <!-- Contenedor ancho para ADMIN (90% del ancho) -->
            <div class="max-w-[90%] mx-auto px-4">
                <div class="bg-gray-800 bg-opacity-60 p-8 rounded-lg shadow-lg overflow-hidden">
                    <h2 class="text-3xl font-bold text-center mb-6 text-white">
                        <span class="text-red-500">Panel</span> de Control
                    </h2>

                    <!-- Contenedor grid para las cards de ADMIN -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-8">
                        <!-- Card: Gestión de Usuarios -->
                        <a href="{{ route('users.index') }}" class="block transform transition hover:scale-105">
                            <div class="bg-cover bg-center h-64 rounded-lg shadow-lg"
                                style="background-image: url('/storage/fondoAccDash/usuarios.jpg');">
                            </div>
                            <div class="mt-4 text-center">
                                <span class="text-white text-2xl font-bold">
                                    Gestión de Usuarios
                                </span>
                            </div>
                        </a>

                        <!-- Card: Gestión de Membresías -->
                        <a href="{{ route('memberships.index') }}" class="block transform transition hover:scale-105">
                            <div class="bg-cover bg-center h-64 rounded-lg shadow-lg"
                                style="background-image: url('/storage/fondoAccDash/membresias.jpg');">
                            </div>
                            <div class="mt-4 text-center">
                                <span class="text-white text-2xl font-bold">
                                    Gestión de Membresías
                                </span>
                            </div>
                        </a>

                        <!-- Card: Gestión de Entrenadores -->
                        <a href="{{ route('trainers.index') }}" class="block transform transition hover:scale-105">
                            <div class="bg-cover bg-center h-64 rounded-lg shadow-lg"
                                style="background-image: url('/storage/fondoAccDash/entrenadores.jpg');">
                            </div>
                            <div class="mt-4 text-center">
                                <span class="text-white text-2xl font-bold">
                                    Gestión de Entrenadores
                                </span>
                            </div>
                        </a>

                        <!-- Card: Gestión de Actividades -->
                        <a href="{{ route('activities.index') }}" class="block transform transition hover:scale-105">
                            <div class="bg-cover bg-center h-64 rounded-lg shadow-lg"
                                style="background-image: url('/storage/fondoAccDash/actividades.jpeg');">
                            </div>
                            <div class="mt-4 text-center">
                                <span class="text-white text-2xl font-bold">
                                    Gestión de Actividades
                                </span>
                            </div>
                        </a>

                        <!-- Card: Gestión de Reservas -->
                        <a href="{{ route('user.admin.reservations') }}"
                            class="block transform transition hover:scale-105">
                            <div class="bg-cover bg-center h-64 rounded-lg shadow-lg"
                                style="background-image: url('/storage/fondoAccDash/reservas.jpg');">
                            </div>
                            <div class="mt-4 text-center">
                                <span class="text-white text-2xl font-bold">
                                    Gestión de Reservas
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @else
            <!-- Contenedor más estrecho para usuarios NORMAL (50% del ancho) -->
            <div class="max-w-[60%] mx-auto px-4">
                <div class="bg-gray-800 bg-opacity-60 p-8 rounded-lg shadow-lg overflow-hidden">
                    <h2 class="text-3xl font-bold text-center mb-6 text-white">
                        <span class="text-red-500">Panel</span> de Control
                    </h2>

                    <!-- Contenedor grid para las cards de NORMAL -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8">
                        <!-- Card: Actividades Disponibles -->
                        <a href="{{ route('activities.user-cards') }}"
                            class="block transform transition hover:scale-105">
                            <div class="bg-cover bg-center h-64 rounded-lg shadow-lg"
                                style="background-image: url('/storage/fondoAccDash/actividades.jpeg');">
                            </div>
                            <div class="mt-4 text-center">
                                <span class="text-white text-2xl font-bold">
                                    Actividades
                                </span>
                            </div>
                        </a>

                        <!-- Card: Gestión de Reservas USUARIO -->
                        <a href="{{ route('user.reservations') }}" class="block transform transition hover:scale-105">
                            <div class="bg-cover bg-center h-64 rounded-lg shadow-lg"
                                style="background-image: url('/storage/fondoAccDash/reservas.jpg');">
                            </div>
                            <div class="mt-4 text-center">
                                <span class="text-white text-2xl font-bold">
                                    Mis Reservas
                                </span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-app-layout>
