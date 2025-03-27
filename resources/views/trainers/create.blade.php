{{-- filepath: /c:/xampp/htdocs/DWES_Laravel/gymProyect3/resources/views/trainers/create.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nuevo Entrenador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 dark:bg-red-900 dark:text-red-100 dark:border-red-700"
                            role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('trainers.store') }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf

                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Imagen del entrenador -->
                            <div class="w-full md:w-1/4 flex flex-col items-center">
                                <div class="mb-4 text-center">
                                    <div
                                        class="relative w-40 h-40 overflow-hidden bg-gray-200 dark:bg-gray-700 rounded-full mx-auto">
                                        <img id="preview-image" class="w-full h-full object-cover"
                                            src="{{ asset('storage/placeholder/user-placeholder.png') }}"
                                            alt="Imagen de perfil">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
                                            <span class="text-white text-sm font-medium">Añadir imagen</span>
                                        </div>
                                        <input type="file" name="image" id="image" accept="image/*"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            onchange="previewImage()">
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center">Haz clic para añadir una
                                    imagen (opcional)</p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <!-- Datos del entrenador -->
                            <div class="w-full md:w-3/4 space-y-6">
                                <!-- DNI -->
                                <div>
                                    <x-input-label for="dni" :value="__('DNI')" />
                                    <x-text-input id="dni" name="dni" type="text" class="mt-1 block w-full"
                                        :value="old('dni')" required />
                                    <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                                </div>

                                <!-- Nombre -->
                                <div>
                                    <x-input-label for="first_name" :value="__('Nombre')" />
                                    <x-text-input id="first_name" name="first_name" type="text"
                                        class="mt-1 block w-full" :value="old('first_name')" required />
                                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                                </div>

                                <!-- Apellidos -->
                                <div>
                                    <x-input-label for="last_name" :value="__('Apellidos')" />
                                    <x-text-input id="last_name" name="last_name" type="text"
                                        class="mt-1 block w-full" :value="old('last_name')" required />
                                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                                </div>

                                <!-- Especialidad -->
                                <div>
                                    <x-input-label for="specialty" :value="__('Especialidad')" />
                                    <x-text-input id="specialty" name="specialty" type="text"
                                        class="mt-1 block w-full" :value="old('specialty')" required />
                                    <x-input-error :messages="$errors->get('specialty')" class="mt-2" />
                                </div>

                                <!-- Botones de formulario -->
                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('trainers.index') }}"
                                        class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-300 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 me-3">
                                        Cancelar
                                    </a>
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                        {{ __('Crear Entrenador') }}
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
