<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles de la Membresía') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex flex-col gap-8 mb-16">
                        <!-- Información de la membresía -->
                        <div class="w-full">
                            <div class="text-center mb-6">
                                <h1 class="text-3xl font-bold">{{ $membership->type }}</h1>
                                @if ($membership->type === 'Sin membresía')
                                    <span
                                        class="inline-block mt-2 px-4 py-1 bg-gray-200 text-gray-700 dark:bg-gray-600 dark:text-gray-300 rounded-full text-sm">
                                        Membresía por defecto
                                    </span>
                                @endif
                            </div>

                            <div class="max-w-2xl mx-auto bg-gray-50 dark:bg-gray-700 rounded-lg p-6 shadow-sm">
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300 mb-4">
                                            Información de la Membresía</h3>

                                        <div class="space-y-4">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">ID</p>
                                                <p class="mt-1">{{ $membership->id }}</p>
                                            </div>

                                            <div>
                                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Precio
                                                </p>
                                                <p
                                                    class="mt-1 text-xl font-bold text-emerald-600 dark:text-emerald-400">
                                                    {{ number_format($membership->price, 2) }} €
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                                    Duración</p>
                                                <p class="mt-1">
                                                    @if ($membership->duration_months == 0)
                                                        <span class="text-gray-400 dark:text-gray-500">No
                                                            aplicable</span>
                                                    @elseif ($membership->duration_months == 1)
                                                        1 mes
                                                    @else
                                                        {{ $membership->duration_months }} meses
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-600 dark:text-gray-300 mb-4">
                                            Estadísticas</h3>

                                        <div class="space-y-4">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">
                                                    Usuarios activos</p>
                                                <p class="mt-1 flex items-center">
                                                    <span
                                                        class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $membership->users->count() }}</span>
                                                    <span
                                                        class="ml-2 text-sm text-gray-500 dark:text-gray-400">usuarios</span>
                                                </p>
                                            </div>

                                            <div>
                                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Fecha
                                                    de creación</p>
                                                <p class="mt-1">{{ $membership->created_at->format('d/m/Y H:i') }}</p>
                                            </div>

                                            <div>
                                                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Última
                                                    actualización</p>
                                                <p class="mt-1">{{ $membership->updated_at->format('d/m/Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            @if ($membership->users->count() > 0)
                                <div class="mt-8">
                                    <h3 class="text-xl font-semibold mb-4">Usuarios con esta membresía</h3>
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
                                                </tr>
                                            </thead>
                                            <tbody
                                                class="bg-white dark:bg-gray-700 divide-y divide-gray-200 dark:divide-gray-600">
                                                @foreach ($membership->users as $user)
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
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones agrupadas con diseño mejorado -->
                    <div class="flex justify-between px-20">
                        <!-- Grupo de editar y eliminar juntos a la izquierda -->
                        <div class="space-x-3">
                            <a href="{{ route('memberships.edit', $membership->id) }}"
                                style="background-color: #d97706; color: white;"
                                class="inline-block px-6 py-2 font-medium text-center rounded-md hover:bg-amber-600 transition">
                                Editar
                            </a>
                            <form action="{{ route('memberships.destroy', $membership->id) }}" method="POST"
                                class="inline-block"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta membresía? Los usuarios asociados serán asignados a la membresía por defecto.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition"
                                    {{ $membership->type === 'Sin membresía' ? 'disabled' : '' }}>
                                    Eliminar
                                </button>
                            </form>
                        </div>

                        <!-- Botón volver separado a la derecha -->
                        <a href="{{ route('memberships.index') }}"
                            class="inline-block px-6 py-2 bg-gray-500 text-white font-medium text-center rounded-md hover:bg-gray-600 transition">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
