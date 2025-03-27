<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            {{ __('Editar Actividad') }}
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
                                d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Detalles de la Actividad
                    </h3>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800">
                    <form method="POST" action="{{ route('activities.update', $activity->id) }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        @if (session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 dark:bg-red-900 dark:text-red-100 dark:border-red-700"
                                role="alert">
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-6">
                                <!-- Nombre de la actividad -->
                                <div>
                                    <label for="name"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Nombre de la
                                        Actividad</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 10V3L4 14h7v7l9-11h-7z" />
                                            </svg>
                                        </span>
                                        <input id="name" type="text" name="name"
                                            value="{{ old('name', $activity->name) }}" required autofocus
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Horario -->
                                <div>
                                    <label for="schedule"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Horario</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <input id="schedule" type="text" name="schedule"
                                            value="{{ old('schedule', $activity->schedule) }}" required
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                    <p class="text-sm text-amber-600 dark:text-amber-400 mt-1 flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        Ejemplo: Lunes y Miércoles 18:00 - 19:30
                                    </p>
                                    <x-input-error :messages="$errors->get('schedule')" class="mt-2" />
                                </div>

                                <!-- Capacidad máxima -->
                                <div>
                                    <label for="max_capacity"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Capacidad
                                        Máxima</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                        </span>
                                        <input id="max_capacity" type="number" name="max_capacity"
                                            value="{{ old('max_capacity', $activity->max_capacity) }}" required
                                            min="1"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white" />
                                    </div>
                                    @if ($activity->users->count() > 0)
                                        <p class="text-sm text-amber-600 dark:text-amber-400 mt-1 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                            Esta actividad ya tiene {{ $activity->users->count() }} usuario(s)
                                            inscritos. Si reduces la capacidad por debajo de este número, no se podrán
                                            inscribir nuevos usuarios.
                                        </p>
                                    @endif
                                    <x-input-error :messages="$errors->get('max_capacity')" class="mt-2" />
                                </div>

                                <!-- Entrenador asignado -->
                                <div>
                                    <label for="trainer_id"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Entrenador
                                        Asignado</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                        </span>
                                        <select id="trainer_id" name="trainer_id"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                            <option value="">Sin entrenador asignado</option>
                                            @foreach ($trainers as $trainer)
                                                <option value="{{ $trainer->id }}"
                                                    {{ old('trainer_id', $activity->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                                    {{ $trainer->first_name }} {{ $trainer->last_name }} -
                                                    {{ $trainer->specialty }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error :messages="$errors->get('trainer_id')" class="mt-2" />
                                </div>
                            </div>

                            <div class="space-y-6">
                                <!-- Imagen -->
                                <div>
                                    <label for="image"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Imagen</label>

                                    <div class="mt-2 flex flex-col items-center space-y-4">
                                        <div
                                            class="w-48 h-48 overflow-hidden rounded-lg shadow-md border-2 border-amber-300 dark:border-amber-700 bg-amber-50 dark:bg-amber-900/30">
                                            @if ($activity->image)
                                                <img id="preview-image"
                                                    src="{{ asset('storage/' . $activity->image) }}"
                                                    alt="{{ $activity->name }}" class="w-full h-full object-cover">
                                            @else
                                                <div id="preview-placeholder"
                                                    class="w-full h-full flex items-center justify-center text-amber-500 dark:text-amber-400">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                    </svg>
                                                </div>
                                                <img id="preview-image" src="" alt=""
                                                    class="w-full h-full object-cover hidden">
                                            @endif
                                        </div>

                                        <input id="image" type="file" name="image" class="hidden"
                                            accept="image/*" onchange="showPreview(this)">
                                        <label for="image"
                                            class="cursor-pointer px-4 py-2 bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 rounded-md border border-amber-300 dark:border-amber-700 hover:bg-amber-200 dark:hover:bg-amber-800/40 transition flex items-center justify-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                            </svg>
                                            Seleccionar nueva imagen
                                        </label>

                                        @if ($activity->image)
                                            <div
                                                class="text-center text-sm text-amber-600 dark:text-amber-400 flex items-center justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>La imagen actual se reemplazará si seleccionas una nueva</span>
                                            </div>
                                        @endif
                                    </div>

                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>

                                @if ($activity->users->count() > 0)
                                    <div
                                        class="p-4 border border-blue-200 dark:border-blue-800 rounded-md bg-blue-50 dark:bg-blue-900/30 mt-6">
                                        <h4 class="font-medium text-blue-800 dark:text-blue-300 flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1.5"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                            </svg>
                                            Participantes Actuales
                                        </h4>
                                        <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">
                                            Esta actividad tiene {{ $activity->users->count() }} usuario(s) inscritos.
                                        </p>
                                        <a href="{{ route('activities.show', $activity->id) }}"
                                            class="mt-2 inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:underline">
                                            <span>Ver lista de participantes</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
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
                                Actualizar Actividad
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showPreview(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('preview-image').setAttribute('src', e.target.result);
                    document.getElementById('preview-image').classList.remove('hidden');
                    document.getElementById('preview-placeholder')?.classList.add('hidden');
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>
