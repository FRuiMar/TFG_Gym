{{-- filepath: /c:/xampp/htdocs/DWES_Laravel/gymProyect3/resources/views/trainers/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Entrenador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex flex-col md:flex-row gap-8 mb-16">
                        <!-- Imagen del entrenador -->
                        <div class="w-full md:w-1/3 flex flex-col items-center">
                            <div
                                class="w-48 h-48 rounded-full overflow-hidden border-4 border-gray-200 dark:border-gray-700 mb-4">
                                @if ($trainer->image)
                                    <img src="{{ asset('storage/' . $trainer->image) }}"
                                        alt="{{ $trainer->first_name }} {{ $trainer->last_name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                        <span
                                            class="text-4xl font-bold text-gray-500 dark:text-gray-400">{{ substr($trainer->first_name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h1 class="text-2xl font-bold text-center">{{ $trainer->first_name }}
                                {{ $trainer->last_name }}</h1>
                            <div class="mt-2">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-200 text-blue-900 dark:bg-blue-600 dark:text-white">
                                    Entrenador
                                </span>
                            </div>
                        </div>

                        <!-- Información del entrenador -->
                        <div class="w-full md:w-2/3">
                            <h3 class="text-lg font-medium text-gray-600 dark:text-gray-300 mb-2">Información Personal
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">DNI</p>
                                    <p class="mt-1">{{ $trainer->dni ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Especialidad</p>
                                    <p class="mt-1">{{ $trainer->specialty ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Fecha de
                                        contratación</p>
                                    <p class="mt-1">{{ $trainer->created_at->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Número de
                                        actividades</p>
                                    <p class="mt-1">
                                        <span
                                            class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800 dark:bg-indigo-700 dark:text-indigo-100">
                                            {{ $trainer->activities->count() }} actividades
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($trainer->activities->count() > 0)
                        <div class="mt-6 mb-10">
                            <h3 class="text-xl font-semibold mb-4">Actividades asignadas</h3>
                            <div class="overflow-x-auto bg-white dark:bg-gray-700 rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Actividad
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Horario
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Capacidad máxima
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Participantes
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Acción
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach ($trainer->activities as $activity)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if ($activity->image)
                                                            <img class="h-8 w-8 rounded object-cover mr-3"
                                                                src="{{ asset('storage/' . $activity->image) }}"
                                                                alt="{{ $activity->name }}">
                                                        @else
                                                            <div
                                                                class="h-8 w-8 rounded bg-gray-200 dark:bg-gray-600 flex items-center justify-center mr-3">
                                                                <span
                                                                    class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                                                    {{ substr($activity->name, 0, 1) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                        <span class="font-medium">{{ $activity->name }}</span>
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $activity->schedule }}
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $activity->max_capacity }} personas
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <span
                                                        class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-700 dark:text-blue-100">
                                                        {{ $activity->users->count() }} /
                                                        {{ $activity->max_capacity }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <a href="{{ route('activities.show', $activity->id) }}"
                                                        class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                                        Ver detalles
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-10">
                            <p class="text-gray-500 dark:text-gray-400">Este entrenador no tiene actividades asignadas
                                actualmente.</p>
                        </div>
                    @endif

                    <!-- Acciones agrupadas con diseño mejorado -->
                    <div class="flex justify-between px-20">
                        <!-- Grupo de editar y eliminar juntos a la izquierda -->
                        <div class="space-x-3">
                            <a href="{{ route('trainers.edit', $trainer->id) }}"
                                style="background-color: #d97706; color: white;"
                                class="inline-block px-6 py-2 font-medium text-center rounded-md hover:bg-amber-600 transition">
                                Editar
                            </a>
                            <form action="{{ route('trainers.destroy', $trainer->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este entrenador? Esta acción no se puede deshacer y afectará a las actividades asignadas.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>

                        <!-- Botón volver separado a la derecha -->
                        <a href="{{ route('trainers.index') }}"
                            class="inline-block px-6 py-2 bg-gray-500 text-white font-medium text-center rounded-md hover:bg-gray-600 transition">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
