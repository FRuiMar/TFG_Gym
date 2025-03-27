<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mis Reservas') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white bg-opacity-50 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl text-gray-800 font-semibold mb-6">Mis Actividades Reservadas</h1>

                    @if (isset($reservations) && count($reservations) > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach ($reservations as $reservation)
                                <div
                                    class="flex flex-col bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-700 dark:border-gray-600 overflow-hidden h-full">
                                    <div class="flex flex-row h-full">
                                        <!-- Imagen izquierda -->
                                        <div class="w-1/3 bg-gray-200 dark:bg-gray-600">
                                            @if ($reservation->image)
                                                <img class="object-cover w-full h-full"
                                                    src="{{ asset('storage/' . $reservation->image) }}"
                                                    alt="{{ $reservation->name }}">
                                            @else
                                                <div
                                                    class="flex items-center justify-center h-full bg-gray-300 dark:bg-gray-600">
                                                    <svg class="w-16 h-16 text-gray-400 dark:text-gray-500"
                                                        xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="1" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Contenido derecha -->
                                        <div class="w-2/3 p-4 flex flex-col h-full bg-gray-500 bg-opacity-60">
                                            <div class="flex-grow">
                                                <!-- Título -->
                                                <h5
                                                    class="mb-2 text-xl font-bold tracking-tight text-gray-900 dark:text-white">
                                                    {{ $reservation->name }}
                                                </h5>

                                                <!-- Detalles -->
                                                <div class="space-y-2 text-sm text-gray-700 dark:text-gray-300">
                                                    <p class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span>{{ $reservation->schedule }}</span>
                                                    </p>

                                                    <p class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        @if ($reservation->trainer)
                                                            {{ $reservation->trainer->first_name }}
                                                            {{ $reservation->trainer->last_name }}
                                                        @else
                                                            Sin entrenador asignado
                                                        @endif
                                                    </p>

                                                    <p class="flex items-center">
                                                        <svg class="w-4 h-4 mr-1" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        {{ \Carbon\Carbon::parse($reservation->pivot->reservation_date)->format('d/m/Y H:i') }}
                                                    </p>
                                                </div>
                                            </div>

                                            <!-- Botón Cancelar -->
                                            <div class="mt-4 flex justify-end">
                                                <form
                                                    action="{{ route('user.reservations.cancel', $reservation->pivot->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center px-3 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-500 dark:hover:bg-red-600 dark:focus:ring-red-700"
                                                        onclick="return confirm('¿Estás seguro de que deseas cancelar esta reserva?')">
                                                        <svg class="w-4 h-4 mr-2" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Cancelar
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">No tienes ninguna actividad reservada.</p>
                            <a href="{{ route('activities.index') }}"
                                class="mt-4 inline-block text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300">
                                Ver actividades disponibles
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
