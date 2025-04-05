<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Sesión') }} - {{ $activity->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if (session('error'))
                        <div class="mb-4 p-4 text-sm text-red-700 bg-red-100 rounded-lg dark:bg-red-200 dark:text-red-800"
                            role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('class-sessions.update', $classSession) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <!-- Día de la semana -->
                            <div>
                                <x-input-label for="dia_semana" :value="__('Día de la semana')" />
                                <select id="dia_semana" name="dia_semana"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @foreach ($diasSemana as $dia)
                                        <option value="{{ $dia }}"
                                            {{ old('dia_semana', $classSession->dia_semana) == $dia ? 'selected' : '' }}>
                                            {{ $dia }}</option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('dia_semana')" class="mt-2" />
                            </div>

                            <!-- Entrenador -->
                            <div>
                                <x-input-label for="trainer_id" :value="__('Entrenador')" />
                                <select id="trainer_id" name="trainer_id"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @foreach ($trainers as $trainer)
                                        <option value="{{ $trainer->id }}"
                                            {{ old('trainer_id', $classSession->trainer_id) == $trainer->id ? 'selected' : '' }}>
                                            {{ $trainer->name }} {{ $trainer->surname }} {{ $trainer->surname2 }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('trainer_id')" class="mt-2" />
                            </div>

                            <!-- Hora inicio -->
                            <div>
                                <x-input-label for="hora_inicio" :value="__('Hora inicio')" />
                                <x-text-input id="hora_inicio" type="time" name="hora_inicio" :value="old('hora_inicio', substr($classSession->hora_inicio, 0, 5))"
                                    class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('hora_inicio')" class="mt-2" />
                            </div>

                            <!-- Hora fin -->
                            <div>
                                <x-input-label for="hora_fin" :value="__('Hora fin')" />
                                <x-text-input id="hora_fin" type="time" name="hora_fin" :value="old('hora_fin', substr($classSession->hora_fin, 0, 5))"
                                    class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('hora_fin')" class="mt-2" />
                            </div>

                            <!-- Sala -->
                            <div>
                                <x-input-label for="sala" :value="__('Sala')" />
                                <x-text-input id="sala" type="text" name="sala" :value="old('sala', $classSession->sala)"
                                    class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('sala')" class="mt-2" />
                            </div>

                            <!-- Capacidad máxima -->
                            <div>
                                <x-input-label for="capacidad_max" :value="__('Capacidad máxima')" />
                                <x-text-input id="capacidad_max" type="number" min="1" name="capacidad_max"
                                    :value="old('capacidad_max', $classSession->capacidad_max)" class="mt-1 block w-full" required />
                                <x-input-error :messages="$errors->get('capacidad_max')" class="mt-2" />
                            </div>

                            <!-- Notas -->
                            <div class="md:col-span-2">
                                <x-input-label for="notes" :value="__('Notas')" />
                                <textarea id="notes" name="notes"
                                    class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('notes', $classSession->notes) }}</textarea>
                                <x-input-error :messages="$errors->get('notes')" class="mt-2" />
                            </div>

                            <!-- Estado Activa -->
                            <div class="md:col-span-2">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        {{ old('is_active', $classSession->is_active) ? 'checked' : '' }}>
                                    <span
                                        class="ml-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Sesión activa') }}</span>
                                </label>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('activities.index') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-300 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-400 dark:hover:bg-gray-600 focus:bg-gray-400 dark:focus:bg-gray-600 active:bg-gray-500 dark:active:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mr-2">
                                {{ __('Cancelar') }}
                            </a>
                            <x-primary-button>
                                {{ __('Actualizar') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
