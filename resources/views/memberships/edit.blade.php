<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
            </svg>
            {{ __('Editar Membresía') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-lg sm:rounded-lg border-t-4 border-amber-500">
                <div class="bg-amber-50 dark:bg-gray-700 border-b border-amber-200 dark:border-amber-800 p-4">
                    <h3 class="font-bold text-lg text-amber-800 dark:text-amber-400 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                        Detalles de la Membresía
                    </h3>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800">
                    <form method="POST" action="{{ route('memberships.update', $membership->id) }}" class="space-y-6">
                        @csrf
                        @method('PUT')

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 dark:bg-red-900 dark:text-red-100 dark:border-red-700"
                                role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <div class="max-w-2xl mx-auto space-y-6">
                            <!-- Tipo de membresía -->
                            <div>
                                <label for="type" class="block font-medium text-amber-800 dark:text-amber-400">Tipo
                                    de Membresía</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                    </span>
                                    <input id="type" type="text" name="type"
                                        value="{{ old('type', $membership->type) }}" required autofocus
                                        {{ $membership->type === 'Sin membresía' ? 'disabled' : '' }}
                                        class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white" />
                                </div>
                                <x-input-error :messages="$errors->get('type')" class="mt-2" />

                                @if ($membership->type === 'Sin membresía')
                                    <p class="text-sm text-amber-600 dark:text-amber-400 mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        No puedes modificar el nombre de la membresía por defecto.
                                    </p>
                                @endif
                            </div>

                            <!-- Precio -->
                            <div>
                                <label for="price"
                                    class="block font-medium text-amber-800 dark:text-amber-400">Precio (€)</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </span>
                                    <input id="price" type="number" name="price"
                                        value="{{ old('price', $membership->price) }}" required step="0.01"
                                        min="0"
                                        class="flex-1 block w-full rounded-none border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white" />
                                    <span
                                        class="inline-flex items-center px-3 rounded-r-md border border-l-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                        €
                                    </span>
                                </div>
                                <x-input-error :messages="$errors->get('price')" class="mt-2" />
                            </div>

                            <!-- Duración en meses -->
                            <div>
                                <label for="duration_months"
                                    class="block font-medium text-amber-800 dark:text-amber-400">Duración
                                    (meses)</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <span
                                        class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </span>
                                    <input id="duration_months" type="number" name="duration_months"
                                        value="{{ old('duration_months', $membership->duration_months) }}" required
                                        min="0"
                                        class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white" />
                                </div>
                                <p class="text-sm text-amber-600 dark:text-amber-400 mt-1 flex items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Usar 0 para membresías sin duración específica.
                                </p>
                                <x-input-error :messages="$errors->get('duration_months')" class="mt-2" />
                            </div>

                            @if ($membership->users->count() > 0)
                                <div
                                    class="p-4 border border-blue-200 dark:border-blue-800 rounded-md bg-blue-50 dark:bg-blue-900/30 mt-6">
                                    <h3 class="font-medium text-blue-800 dark:text-blue-300 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Usuarios con esta membresía
                                    </h3>
                                    <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">
                                        Esta membresía está asignada a {{ $membership->users->count() }} usuario(s).
                                        Los cambios afectarán a todos los usuarios que tengan esta membresía asignada.
                                    </p>
                                    <a href="{{ route('memberships.show', $membership->id) }}"
                                        class="mt-2 inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                        <span>Ver lista de usuarios con esta membresía</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                        </svg>
                                    </a>
                                </div>
                            @endif

                            <!-- Botones de formulario -->
                            <div
                                class="flex items-center justify-end mt-8 pt-5 border-t border-amber-200 dark:border-amber-800">
                                <a href="{{ url()->previous() }}"
                                    class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-amber-500 dark:focus:ring-amber-600 focus:ring-offset-2 mr-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                                    </svg>
                                    Cancelar
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-amber-600 dark:bg-amber-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-700 dark:hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                    Guardar Cambios
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
