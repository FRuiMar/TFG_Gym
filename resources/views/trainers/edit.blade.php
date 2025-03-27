<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            {{ __('Editar Entrenador') }}
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
                                d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Información del Entrenador
                    </h3>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800">
                    <form method="POST" action="{{ route('trainers.update', $trainer) }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Imagen del entrenador -->
                            <div class="w-full md:w-1/4 flex flex-col items-center">
                                <div class="mb-4 text-center">
                                    <div
                                        class="relative w-40 h-40 overflow-hidden bg-amber-100 dark:bg-amber-900 rounded-full mx-auto border-2 border-amber-300 dark:border-amber-700 shadow-md">
                                        <img id="preview-image" class="w-full h-full object-cover"
                                            src="{{ $trainer->image ? asset('storage/' . $trainer->image) : asset('storage/placeholder/user-placeholder.png') }}"
                                            alt="Imagen de perfil">
                                        <div
                                            class="absolute inset-0 bg-amber-800 bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
                                            <span class="text-white text-sm font-medium">Cambiar imagen</span>
                                        </div>
                                        <input type="file" name="image" id="image" accept="image/*"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            onchange="previewImage()">
                                    </div>
                                </div>
                                <p class="text-sm text-amber-700 dark:text-amber-400 text-center">Haz clic para cambiar
                                    la imagen (opcional)</p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <!-- Datos del entrenador -->
                            <div class="w-full md:w-3/4 space-y-6">
                                <!-- DNI -->
                                <div>
                                    <label for="dni"
                                        class="block font-medium text-amber-800 dark:text-amber-400">DNI</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                                            </svg>
                                        </span>
                                        <input id="dni" name="dni" type="text"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            value="{{ old('dni', $trainer->dni) }}" required />
                                    </div>
                                    <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                                </div>

                                <!-- Nombre -->
                                <div>
                                    <label for="first_name"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Nombre</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                        </span>
                                        <input id="first_name" name="first_name" type="text"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            value="{{ old('first_name', $trainer->first_name) }}" required />
                                    </div>
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>

                                <!-- Apellidos -->
                                <div>
                                    <label for="last_name"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Apellidos</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </span>
                                        <input id="last_name" name="last_name" type="text"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            value="{{ old('last_name', $trainer->last_name) }}" required />
                                    </div>
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>

                                <!-- Especialidad -->
                                <div>
                                    <label for="specialty"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Especialidad</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                            </svg>
                                        </span>
                                        <input id="specialty" name="specialty" type="text"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            value="{{ old('specialty', $trainer->specialty) }}" required />
                                    </div>
                                    <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
                                </div>

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
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage() {
            const input = document.getElementById('image');
            const preview = document.getElementById('preview-image');

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                }

                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
