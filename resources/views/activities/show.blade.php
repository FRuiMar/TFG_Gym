<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles de la Actividad') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex flex-col md:flex-row gap-8 mb-16">
                        <!-- Imagen de la actividad -->
                        <div class="w-full md:w-1/3 flex flex-col items-center">
                            <div
                                class="w-48 h-48 rounded-lg overflow-hidden border-4 border-gray-200 dark:border-gray-700 mb-4">
                                @if ($activity->image)
                                    <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                        <span
                                            class="text-4xl font-bold text-gray-500 dark:text-gray-400">{{ substr($activity->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h1 class="text-2xl font-bold text-center">{{ $activity->name }}</h1>
                            <div class="mt-2 text-center">
                                <span
                                    class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                    {{ $activity->users->count() }}/{{ $activity->max_capacity }} participantes
                                </span>
                            </div>
                        </div>

                        <!-- Información de la actividad -->
                        <div class="w-full md:w-2/3">
                            <h3 class="text-lg font-medium text-gray-600 dark:text-gray-300 mb-2">Detalles de la
                                Actividad</h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Horario</p>
                                    <p class="mt-1">{{ $activity->schedule }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Capacidad Máxima
                                    </p>
                                    <p class="mt-1">{{ $activity->max_capacity }} personas</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Entrenador
                                        Asignado</p>
                                    <p class="mt-1">
                                        @if ($activity->trainer)
                                            <div class="flex items-center">
                                                @if ($activity->trainer->image)
                                                    <img class="h-8 w-8 rounded-full object-cover mr-2"
                                                        src="{{ asset('storage/' . $activity->trainer->image) }}"
                                                        alt="{{ $activity->trainer->first_name }}">
                                                @else
                                                    <div
                                                        class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center mr-2">
                                                        <span
                                                            class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                                            {{ substr($activity->trainer->first_name, 0, 1) }}
                                                        </span>
                                                    </div>
                                                @endif
                                                <a href="{{ route('trainers.show', $activity->trainer->id) }}"
                                                    class="text-blue-600 dark:text-blue-400 hover:underline">
                                                    {{ $activity->trainer->first_name }}
                                                    {{ $activity->trainer->last_name }}
                                                </a>
                                            </div>
                                        @else
                                            <span class="text-gray-400 dark:text-gray-500">No hay entrenador
                                                asignado</span>
                                        @endif
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Fecha de creación
                                    </p>
                                    <p class="mt-1">{{ $activity->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if ($activity->users->count() > 0)
                        <div class="mt-6 mb-10">
                            <h3 class="text-xl font-semibold mb-4">Participantes inscritos</h3>
                            <div class="overflow-x-auto bg-white dark:bg-gray-700 rounded-lg shadow">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-800">
                                        <tr>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Nombre
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Email
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Rol
                                            </th>
                                            <th
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                                Membresía
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody
                                        class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                        @foreach ($activity->users as $user)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        @if ($user->image)
                                                            <img class="h-8 w-8 rounded-full object-cover mr-3"
                                                                src="{{ asset('storage/' . $user->image) }}"
                                                                alt="{{ $user->name }}">
                                                        @else
                                                            <div
                                                                class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center mr-3">
                                                                <span
                                                                    class="text-xs font-medium text-gray-600 dark:text-gray-300">
                                                                    {{ substr($user->name, 0, 1) }}
                                                                </span>
                                                            </div>
                                                        @endif
                                                        <a href="{{ route('users.show', $user->id) }}"
                                                            class="text-sm font-medium text-blue-600 dark:text-blue-400 hover:underline">
                                                            {{ $user->name }}
                                                        </a>
                                                    </div>
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $user->email }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if ($user->role == 'ADMIN')
                                                        <span
                                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800 dark:bg-purple-700 dark:text-purple-100">
                                                            {{ $user->role }}
                                                        </span>
                                                    @else
                                                        <span
                                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                                            {{ $user->role }}
                                                        </span>
                                                    @endif
                                                </td>
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                    {{ $user->membership ? $user->membership->type : 'Sin membresía' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 bg-gray-50 dark:bg-gray-700 rounded-lg mb-10">
                            <p class="text-gray-500 dark:text-gray-400">No hay usuarios inscritos en esta actividad.</p>
                        </div>
                    @endif

                    <!-- Acciones agrupadas con diseño mejorado -->
                    <div class="flex justify-between px-20">
                        <!-- Grupo de editar y eliminar juntos a la izquierda -->
                        <div class="space-x-3">
                            <a href="{{ route('activities.edit', $activity->id) }}"
                                style="background-color: #d97706; color: white;"
                                class="inline-block px-6 py-2 font-medium text-center rounded-md hover:bg-amber-600 transition">
                                Editar
                            </a>
                            <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta actividad? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>

                        <!-- Botón volver separado a la derecha -->
                        <a href="{{ route('activities.index') }}"
                            class="inline-block px-6 py-2 bg-gray-500 text-white font-medium text-center rounded-md hover:bg-gray-600 transition">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
