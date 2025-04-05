<div>
    <!-- Header con título estilizado limpio y moderno -->
    <div class="flex justify-between items-center mb-6">
        <h1
            class="text-2xl font-bold text-gray-800 dark:text-gray-200 pb-2 border-b-2 border-gray-200 dark:border-gray-700 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 mr-2 text-blue-600 dark:text-blue-400" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            Actividades Registradas
        </h1>
        <div class="space-x-2">
            <a href="{{ route('activities.create') }}"
                class="px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-800 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-sm">
                <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                        clip-rule="evenodd"></path>
                </svg>
                Nueva Actividad
            </a>
        </div>
    </div>

    <!-- Panel de filtros mejorado visualmente -->
    <div class="mb-6 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700">
        <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <!-- Buscador con estilo mejorado -->
            <div class="w-full md:w-1/3">
                <label for="search" class="sr-only">Buscar</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input wire:model.live="search" id="search"
                        class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-md leading-5 bg-white dark:bg-gray-700 dark:text-white placeholder-gray-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 sm:text-sm shadow-sm"
                        placeholder="Buscar por nombre o horario...">
                </div>
            </div>

            <div class="flex gap-4 w-full md:w-auto">
                <!-- Selector de entrenador estilizado -->
                <div class="w-full md:w-auto">
                    <select wire:model.live="filterTrainer"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 shadow-sm">
                        <option value="">Todos los entrenadores</option>
                        @foreach ($trainers as $trainer)
                            <option value="{{ $trainer->id }}">{{ $trainer->name }} {{ $trainer->surname }}
                                {{ $trainer->surname }}
                            </option>
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Selector de elementos por página estilizado -->
                <div class="w-full md:w-auto">
                    <select wire:model.live="perPage"
                        class="block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md bg-white dark:bg-gray-700 dark:text-white dark:border-gray-600 shadow-sm">
                        <option value="5">5 por página</option>
                        <option value="10">10 por página</option>
                        <option value="25">25 por página</option>
                        <option value="50">50 por página</option>
                        <option value="100">100 por página</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de actividades con estilo mejorado y limpio -->
    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded-lg shadow-md">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th scope="col" class="w-12"></th> <!-- Columna para botón expandir -->
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Imagen
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('nombre')">
                        Nombre
                        @if ($sortField === 'nombre')
                            <!-- Iconos de ordenación -->
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('duracion_minutos')">
                        Duración
                        @if ($sortField === 'duracion_minutos')
                            <!-- Iconos de ordenación -->
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('nivel_dificultad')">
                        Nivel
                        @if ($sortField === 'nivel_dificultad')
                            <!-- Iconos de ordenación -->
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('calories_burned')">
                        Calorías
                        @if ($sortField === 'calories_burned')
                            <!-- Iconos de ordenación -->
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Sesiones
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider cursor-pointer"
                        wire:click="sortBy('active')">
                        Estado
                        @if ($sortField === 'active')
                            @if ($sortDirection === 'asc')
                                <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 15l7-7 7 7"></path>
                                </svg>
                            @else
                                <svg class="inline-block w-4 h-4 ml-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            @endif
                        @endif
                    </th>
                    <th scope="col"
                        class="px-6 py-4 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                        Acciones
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                @forelse ($activities as $activity)
                    <tr wire:key="activity-{{ $activity->id }}"
                        class="transition-colors duration-200 hover:bg-gray-50 dark:hover:bg-gray-700">
                        <!-- Botón expandir -->
                        <td class="pl-4">
                            <button wire:click="toggleExpand({{ $activity->id }})"
                                class="p-1 text-gray-500 hover:text-blue-600 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/30 focus:outline-none">
                                @if (isset($expandedRows[$activity->id]) && $expandedRows[$activity->id])
                                    <svg class="w-5 h-5 transform rotate-90 transition-transform duration-200"
                                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 transition-transform duration-200" fill="currentColor"
                                        viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                @endif
                            </button>
                        </td>

                        <!-- Imagen -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center">
                                @if ($activity->imagen)
                                    <div
                                        class="h-14 w-14 flex-shrink-0 overflow-hidden rounded-lg border-2 border-gray-200 dark:border-gray-600 shadow-md transition-transform duration-300 hover:scale-110">
                                        <img class="h-full w-full object-cover"
                                            src="{{ asset('storage/' . $activity->imagen) }}"
                                            alt="{{ $activity->nombre }}">
                                    </div>
                                @else
                                    <div
                                        class="h-14 w-14 rounded-full bg-gray-100 dark:bg-gray-700 border-2 border-gray-200 dark:border-gray-600 flex items-center justify-center shadow-md">
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-6 w-6 text-gray-400 dark:text-gray-500" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>

                        <!-- Nombre -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $activity->nombre }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 line-clamp-1"
                                title="{{ $activity->descripcion }}">
                                {{ Str::limit($activity->descripcion, 30) }}
                            </div>
                        </td>

                        <!-- Duración -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-500 mr-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span
                                    class="text-sm text-gray-600 dark:text-gray-300">{{ $activity->duracion_minutos }}
                                    min</span>
                            </div>
                        </td>

                        <!-- Nivel de dificultad -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $activity->nivel_dificultad === 'principiante' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : '' }}
                                {{ $activity->nivel_dificultad === 'intermedio' ? 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200' : '' }}
                                {{ $activity->nivel_dificultad === 'avanzado' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : '' }}">
                                {{ ucfirst($activity->nivel_dificultad) }}
                            </span>
                        </td>

                        <!-- Calorías -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-500 mr-1"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                                <span
                                    class="text-sm text-gray-600 dark:text-gray-300">{{ $activity->calories_burned ?? '-' }}
                                    kcal</span>
                            </div>
                        </td>

                        <!-- Contador de sesiones -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span
                                class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                {{ $activity->classSessions->count() }} sesiones
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if ($activity->active)
                                <span
                                    class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                    Activa
                                </span>
                            @else
                                <span
                                    class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                    Inactiva
                                </span>
                            @endif
                        </td>


                        <!-- Acciones -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <a href="{{ route('activities.show', $activity->id) }}"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 p-1.5 rounded-full hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"></path>
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </a>
                                <a href="{{ route('activities.edit', $activity->id) }}"
                                    class="text-yellow-600 hover:text-yellow-900 dark:text-yellow-400 dark:hover:text-yellow-300 p-1.5 rounded-full hover:bg-yellow-100 dark:hover:bg-yellow-900/50 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                        </path>
                                    </svg>
                                </a>
                                <button type="button"
                                    wire:click.prevent="confirmActivityDeletion({{ $activity->id }})"
                                    class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300 p-1.5 rounded-full hover:bg-red-100 dark:hover:bg-red-900/50 transition-colors">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Fila expandible para sesiones -->
                    @if (isset($expandedRows[$activity->id]) && $expandedRows[$activity->id])
                        <tr class="bg-gray-50 dark:bg-gray-700/50">
                            <td colspan="7" class="px-6 py-4">
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-3">
                                    <h3 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Sesiones de
                                        {{ $activity->nombre }}</h3>

                                    @if ($activity->classSessions->isEmpty())
                                        <p class="text-sm text-gray-500 dark:text-gray-400 py-2">No hay sesiones
                                            programadas para esta actividad.</p>
                                    @else
                                        <div class="overflow-x-auto">
                                            <table
                                                class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 rounded-lg overflow-hidden">
                                                <thead class="bg-gray-100 dark:bg-gray-800">
                                                    <tr>
                                                        <th
                                                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                            Día</th>
                                                        <th
                                                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                            Horario</th>
                                                        <th
                                                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                            Sala</th>
                                                        <th
                                                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                            Capacidad</th>
                                                        <th
                                                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                            Entrenador</th>
                                                        <th
                                                            class="px-3 py-2 text-left text-xs font-medium text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                                                            Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody
                                                    class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-800">
                                                    @foreach ($activity->classSessions as $session)
                                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                                            <td
                                                                class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                                {{ $session->dia_semana }}
                                                            </td>
                                                            <td
                                                                class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                                {{ \Carbon\Carbon::parse($session->hora_inicio)->format('H:i') }}
                                                                -
                                                                {{ \Carbon\Carbon::parse($session->hora_fin)->format('H:i') }}
                                                            </td>
                                                            <td
                                                                class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                                {{ $session->sala }}
                                                            </td>
                                                            <td
                                                                class="px-3 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">
                                                                {{ $session->capacidad_max }}
                                                            </td>
                                                            <td class="px-3 py-2 whitespace-nowrap">
                                                                @if ($session->trainer)
                                                                    <span
                                                                        class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                                        {{ $session->trainer->name }}
                                                                        {{ $session->trainer->surname }}
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="px-2 py-1 inline-flex text-xs leading-4 font-semibold rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                                                        Sin asignar
                                                                    </span>
                                                                @endif
                                                            </td>
                                                            <td class="px-3 py-2 whitespace-nowrap">
                                                                <div class="flex space-x-1">
                                                                    <a href="{{ route('class-sessions.edit', $session->id) }}"
                                                                        class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 p-1 rounded-full hover:bg-indigo-100 dark:hover:bg-indigo-900/30">
                                                                        <svg class="w-4 h-4" fill="currentColor"
                                                                            viewBox="0 0 20 20"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path
                                                                                d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z">
                                                                            </path>
                                                                        </svg>
                                                                    </a>
                                                                    <button
                                                                        wire:click="confirmSessionDeletion({{ $session->id }})"
                                                                        class="text-red-600 hover:text-red-900 dark:text-red-400 p-1 rounded-full hover:bg-red-100 dark:hover:bg-red-900/30">
                                                                        <svg class="w-4 h-4" fill="currentColor"
                                                                            viewBox="0 0 20 20"
                                                                            xmlns="http://www.w3.org/2000/svg">
                                                                            <path fill-rule="evenodd"
                                                                                d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                                clip-rule="evenodd"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="mt-3 flex justify-end">
                                            <a href="{{ route('class-sessions.create', ['activity_id' => $activity->id]) }}"
                                                class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 20 20"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                Añadir sesión
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <!-- Mensaje de "No se encontraron actividades" -->
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación con estilo mejorado -->
    <div
        class="mt-6 bg-white dark:bg-gray-800 px-4 py-3 rounded-lg shadow-md border border-gray-200 dark:border-gray-700 flex items-center justify-between">
        <!-- Contador de resultados -->
        <div class="flex-1 text-sm text-gray-700 dark:text-gray-300">
            <p class="font-medium">
                Mostrando
                <span
                    class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $activities->firstItem() ?? 0 }}-{{ $activities->lastItem() ?? 0 }}
                </span>
                de
                <span
                    class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                    {{ $activities->total() }}
                </span>
                actividades
            </p>
        </div>

        <!-- Controles de paginación -->
        <div class="flex-1 flex justify-end">
            {{ $activities->links() }}
        </div>
    </div>

    <!-- Modal de confirmación de eliminación con estilo mejorado -->
    @if ($showDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <!-- Overlay de fondo con efecto blur -->
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity"></div>

            <!-- Modal container -->
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <!-- Contenido del modal con efecto de aparición -->
                <div
                    class="relative inline-block overflow-hidden text-left align-bottom bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full transform transition-all sm:scale-100 opacity-100">
                    <div class="px-4 pt-5 pb-4 bg-white dark:bg-gray-800 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100"
                                    id="modal-title">
                                    Eliminar actividad
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        ¿Estás seguro que deseas eliminar la actividad
                                        "{{ $activityToDelete->nombre ?? '' }}"? Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteConfirmed" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Eliminar
                        </button>
                        <button wire:click="cancelActivityDeletion" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if ($showSessionDeleteModal)
        <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog"
            aria-modal="true">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 backdrop-blur-sm transition-opacity"></div>
            <div class="flex items-end justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div
                    class="relative inline-block overflow-hidden text-left align-bottom bg-white rounded-lg shadow-xl dark:bg-gray-800 sm:my-8 sm:align-middle sm:max-w-lg sm:w-full transform transition-all sm:scale-100 opacity-100">
                    <div class="px-4 pt-5 pb-4 bg-white dark:bg-gray-800 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div
                                class="flex items-center justify-center flex-shrink-0 w-12 h-12 mx-auto bg-red-100 rounded-full dark:bg-red-900 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                <h3 class="text-lg font-medium leading-6 text-gray-900 dark:text-gray-100">
                                    Eliminar sesión
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        ¿Estás seguro que deseas eliminar esta sesión de
                                        {{ $sessionToDelete ? $sessionToDelete->dia_semana : '' }}
                                        {{ $sessionToDelete ? \Carbon\Carbon::parse($sessionToDelete->hora_inicio)->format('H:i') : '' }}
                                        -
                                        {{ $sessionToDelete ? \Carbon\Carbon::parse($sessionToDelete->hora_fin)->format('H:i') : '' }}?
                                        Esta acción no se puede deshacer.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="px-4 py-3 bg-gray-50 dark:bg-gray-700 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button wire:click="deleteSession" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 text-base font-medium text-white bg-red-600 border border-transparent rounded-md shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Eliminar
                        </button>
                        <button wire:click="cancelSessionDeletion" type="button"
                            class="inline-flex justify-center w-full px-4 py-2 mt-3 text-base font-medium text-gray-700 bg-white border border-gray-300 rounded-md shadow-sm dark:bg-gray-600 dark:text-gray-200 dark:border-gray-500 hover:bg-gray-50 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancelar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

</div>
