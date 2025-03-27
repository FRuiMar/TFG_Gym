<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Crear Nueva Actividad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('activities.store') }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 dark:bg-red-900 dark:text-red-100 dark:border-red-700"
                                role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Imagen de la actividad -->
                            <div class="w-full md:w-1/4 flex flex-col items-center">
                                <div class="mb-4 text-center">
                                    <div
                                        class="relative w-40 h-40 overflow-hidden bg-gray-200 dark:bg-gray-700 rounded-lg mx-auto">
                                        <img id="preview-image" class="w-full h-full object-cover"
                                            src="{{ asset('storage/placeholder/image-placeholder.jpg') }}"
                                            alt="Imagen de actividad">
                                        <div
                                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
                                            <span class="text-white text-sm font-medium">Seleccionar imagen</span>
                                        </div>
                                        <input type="file" name="image" id="image" accept="image/*"
                                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                            onchange="previewImage()">
                                    </div>
                                </div>
                                <p class="text-sm text-gray-500 dark:text-gray-400 text-center">Haz clic para subir una
                                    imagen (opcional)</p>
                                <x-input-error :messages="$errors->get('image')" class="mt-2" />
                            </div>

                            <!-- Campos del formulario -->
                            <div class="w-full md:w-3/4 space-y-6">
                                <!-- Nombre de la actividad -->
                                <div>
                                    <x-input-label for="name" :value="__('Nombre de la Actividad')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                                        :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Horario -->
                                <div>
                                    <x-input-label for="schedule" :value="__('Horario')" />
                                    <x-text-input id="schedule" class="block mt-1 w-full" type="text"
                                        name="schedule" :value="old('schedule')" required />
                                    <x-input-error :messages="$errors->get('schedule')" class="mt-2" />
                                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                                        Ejemplo: Lunes y Miércoles 18:00 - 19:30
                                    </p>
                                </div>

                                <!-- Capacidad máxima -->
                                <div>
                                    <x-input-label for="max_capacity" :value="__('Capacidad Máxima')" />
                                    <x-text-input id="max_capacity" class="block mt-1 w-full" type="number"
                                        name="max_capacity" :value="old('max_capacity')" required min="1" />
                                    <x-input-error :messages="$errors->get('max_capacity')" class="mt-2" />
                                </div>

                                <!-- Entrenador -->
                                <div>
                                    <x-input-label for="trainer_id" :value="__('Entrenador')" />
                                    <select id="trainer_id" name="trainer_id"
                                        class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                        <option value="">Sin entrenador asignado</option>
                                        @foreach ($trainers as $trainer)
                                            <option value="{{ $trainer->id }}"
                                                {{ old('trainer_id') == $trainer->id ? 'selected' : '' }}>
                                                {{ $trainer->first_name }} {{ $trainer->last_name }} -
                                                {{ $trainer->specialty }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('trainer_id')" class="mt-2" />
                                </div>

                                <!-- Información adicional -->
                                <div
                                    class="rounded-md bg-blue-50 dark:bg-blue-900/30 p-4 border border-blue-200 dark:border-blue-800">
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
                                                Información importante
                                            </h3>
                                            <div class="mt-2 text-sm text-blue-700 dark:text-blue-400">
                                                <p>Una vez creada la actividad, los usuarios podrán inscribirse siempre
                                                    que haya plazas disponibles.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8">
                            <a href="{{ route('activities.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-800 dark:text-gray-300 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:bg-gray-300 dark:focus:bg-gray-600 active:bg-gray-300 dark:active:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 me-3">
                                Cancelar
                            </a>
                            <x-primary-button>
                                {{ __('Crear Actividad') }}
                            </x-primary-button>
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
