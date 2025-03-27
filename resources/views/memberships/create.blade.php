<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nueva Membresía') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('memberships.store') }}" class="space-y-6">
                        @csrf

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 dark:bg-red-900 dark:text-red-100 dark:border-red-700"
                                role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <div class="max-w-2xl mx-auto">
                            <!-- Tipo de membresía -->
                            <div class="mb-6">
                                <x-input-label for="type" :value="__('Tipo de Membresía')" />
                                <x-text-input id="type" class="block mt-1 w-full" type="text" name="type"
                                    :value="old('type')" required autofocus
                                    placeholder="Ej: Mensual, Premium, Estudiante..." />
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />
                            </div>

                            <!-- Precio -->
                            <div class="mb-6">
                                <x-input-label for="price" :value="__('Precio (€)')" />
                                <div class="relative mt-1 rounded-md shadow-sm">
                                    <x-text-input id="price" class="block w-full pr-8" type="number" name="price"
                                        :value="old('price')" required step="0.01" min="0" placeholder="0.00" />
                                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                        <span class="text-gray-500 dark:text-gray-400">€</span>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Duración en meses -->
                            <div class="mb-6">
                                <x-input-label for="duration_months" :value="__('Duración (meses)')" />
                                <x-text-input id="duration_months" class="block mt-1 w-full" type="number"
                                    name="duration_months" :value="old('duration_months')" required min="0" placeholder="1" />
                                <x-input-error :messages="$errors->get('duration_months')" class="mt-2" />
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                    Usar 0 para membresías sin duración específica o membresías por defecto.
                                </p>
                            </div>

                            <!-- Información adicional -->
                            <div
                                class="rounded-md bg-blue-50 dark:bg-blue-900/30 p-4 border border-blue-200 dark:border-blue-800 mb-6">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd"
                                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-300">
                                            ¿Cómo funcionan las membresías?
                                        </h3>
                                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                                            <ul class="list-disc pl-5 space-y-1">
                                                <li>Cada membresía debe tener un nombre único</li>
                                                <li>Puedes asignar membresías a los usuarios desde su perfil</li>
                                                <li>Los precios se muestran en euros</li>
                                                <li>La duración se expresa en meses (0 = sin límite de tiempo)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end">
                                <a href="{{ route('memberships.index') }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-300 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 me-3">
                                    Cancelar
                                </a>
                                <x-primary-button>
                                    {{ __('Crear Membresía') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
