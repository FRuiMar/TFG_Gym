<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Usuario') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <div class="flex flex-col md:flex-row gap-8 mb-16">
                        <!-- Imagen del usuario -->
                        <div class="w-full md:w-1/3 flex flex-col items-center">
                            <div
                                class="w-48 h-48 rounded-full overflow-hidden border-4 border-gray-200 dark:border-gray-700 mb-4">
                                @if ($user->image)
                                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                        class="w-full h-full object-cover">
                                @else
                                    <div
                                        class="w-full h-full bg-gray-300 dark:bg-gray-700 flex items-center justify-center">
                                        <span
                                            class="text-4xl font-bold text-gray-500 dark:text-gray-400">{{ substr($user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h1 class="text-2xl font-bold">{{ $user->name }}</h1>
                            <div class="mt-2">
                                @if ($user->role == 'ADMIN')
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-200 text-purple-900 dark:bg-purple-600 dark:text-white uppercase">
                                        {{ $user->role }}
                                    </span>
                                @else
                                    <span
                                        class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-700 dark:text-green-100">
                                        {{ $user->role }}
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Información del usuario -->
                        <div class="w-full md:w-2/3">
                            <h3 class="text-lg font-medium text-gray-600 dark:text-gray-300 mb-2">Información Personal
                            </h3>
                            <div class="space-y-4">
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">DNI</p>
                                    <p class="mt-1">{{ $user->dni ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="mt-1">{{ $user->email }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-500 dark:text-gray-400">Membresía</p>
                                    <p class="mt-1">
                                        {{ $user->membership ? $user->membership->type : 'Sin membresía' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones agrupadas con diseño mejorado -->
                    <div class="flex justify-between px-20">
                        <!-- Grupo de editar y eliminar juntos a la izquierda -->
                        <div class="space-x-3">
                            <a href="{{ route('users.edit', $user->id) }}"
                                style="background-color: #d97706; color: white;"
                                class="inline-block px-6 py-2 font-medium text-center rounded-md hover:bg-amber-600 transition">
                                Editar
                            </a>
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="inline-block"
                                onsubmit="return confirm('¿Estás seguro de que deseas eliminar este usuario? Esta acción no se puede deshacer.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="px-6 py-2 bg-red-600 text-white font-medium rounded-md hover:bg-red-700 transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>


                        {{-- <a href="{{ route('users.index') }}" --}}
                        <a href="{{ url()->previous() }}"
                            class="inline-block px-6 py-2 bg-gray-500 text-white font-medium text-center rounded-md hover:bg-gray-600 transition">
                            Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
