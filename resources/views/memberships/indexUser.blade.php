<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Nuestras Membresías') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h1 class="text-2xl font-bold mb-6 text-center">Membresías Disponibles</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($memberships as $membership)
                            @if ($membership->type !== 'Sin membresía')
                                <div class="bg-white dark:bg-gray-700 rounded-lg shadow-md overflow-hidden">
                                    <div class="p-6">
                                        <h2 class="text-2xl font-bold text-center mb-4">{{ $membership->type }}</h2>

                                        <div class="text-center mb-6">
                                            <span class="text-3xl font-bold">{{ number_format($membership->price, 2) }}
                                                €</span>
                                            <span class="text-gray-600 dark:text-gray-300">
                                                @if ($membership->duration_months == 1)
                                                    / mes
                                                @else
                                                    / {{ $membership->duration_months }} meses
                                                @endif
                                            </span>
                                        </div>

                                        <div class="mb-6">
                                            <ul class="text-gray-600 dark:text-gray-300">
                                                <li class="mb-2 flex items-center">
                                                    <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor"
                                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd"></path>
                                                    </svg>
                                                    Acceso a todas las áreas del gimnasio
                                                </li>
                                                @if ($membership->price >= 40)
                                                    <li class="mb-2 flex items-center">
                                                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        Acceso a clases grupales
                                                    </li>
                                                @endif
                                                @if ($membership->price >= 60)
                                                    <li class="mb-2 flex items-center">
                                                        <svg class="w-5 h-5 mr-2 text-green-500" fill="currentColor"
                                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <path fill-rule="evenodd"
                                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                                clip-rule="evenodd"></path>
                                                        </svg>
                                                        1 sesión con entrenador personal
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>

                                        <div class="text-center">
                                            <a href="{{ route('profile.edit', ['membership_id' => $membership->id]) }}"
                                                class="inline-block px-6 py-3 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700 transition">
                                                Elegir este plan
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
