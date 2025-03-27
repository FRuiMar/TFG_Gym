{{-- filepath: /c:/xampp/htdocs/DWES_Laravel/gymProyect3/resources/views/users/edit.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-amber-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            {{ __('Editar Usuario') }}
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
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Información del Usuario
                    </h3>
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100 bg-white dark:bg-gray-800">
                    <form method="POST" action="{{ route('users.update', $user->id) }}" class="space-y-6"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Imagen del usuario -->
                            <div class="w-full md:w-1/4 flex flex-col items-center">
                                <div class="mb-4 text-center">
                                    <div
                                        class="relative w-40 h-40 overflow-hidden bg-amber-100 dark:bg-amber-900 rounded-full mx-auto border-2 border-amber-300 dark:border-amber-700 shadow-md">
                                        <img id="preview-image" class="w-full h-full object-cover"
                                            src="{{ $user->image ? asset('storage/' . $user->image) : asset('storage/placeholder/user-placeholder.png') }}"
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

                            <!-- Campos del formulario -->
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
                                        <input id="dni"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            type="text" name="dni" value="{{ old('dni', $user->dni) }}"
                                            required />
                                    </div>
                                    <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                                </div>

                                <!-- Name -->
                                <div>
                                    <label for="name"
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
                                        <input id="name"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            type="text" name="name" value="{{ old('name', $user->name) }}"
                                            required />
                                    </div>
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <!-- Email Address -->
                                <div>
                                    <label for="email"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Email</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                        </span>
                                        <input id="email"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            type="email" name="email" value="{{ old('email', $user->email) }}"
                                            required />
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <!-- Password -->
                                <div>
                                    <label for="password"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Contraseña (dejar
                                        en blanco para mantener la actual)</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                            </svg>
                                        </span>
                                        <input id="password"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            type="password" name="password" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Confirmar
                                        Contraseña</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </span>
                                        <input id="password_confirmation"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white"
                                            type="password" name="password_confirmation" />
                                    </div>
                                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                                </div>

                                <!-- Role -->
                                <div>
                                    <label for="role"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Rol</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                        </span>
                                        <select id="role" name="role"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                            <option value="NORMAL" {{ $user->role == 'NORMAL' ? 'selected' : '' }}>
                                                Usuario</option>
                                            <option value="ADMIN" {{ $user->role == 'ADMIN' ? 'selected' : '' }}>
                                                Administrador</option>
                                        </select>
                                    </div>
                                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                                </div>

                                <!-- Membership -->
                                <div>
                                    <label for="membership_id"
                                        class="block font-medium text-amber-800 dark:text-amber-400">Membresía</label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <span
                                            class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-amber-300 dark:border-amber-700 bg-amber-100 dark:bg-amber-900 text-amber-500 dark:text-amber-400">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                            </svg>
                                        </span>
                                        <select id="membership_id" name="membership_id"
                                            class="flex-1 block w-full rounded-r-md border-amber-300 dark:border-amber-700 focus:border-amber-500 focus:ring focus:ring-amber-500 focus:ring-opacity-50 dark:bg-gray-900 dark:text-white">
                                            <option value="">Sin membresía</option>
                                            @foreach ($memberships as $membership)
                                                <option value="{{ $membership->id }}"
                                                    {{ $user->membership_id == $membership->id ? 'selected' : '' }}>
                                                    {{ $membership->type }} - {{ $membership->price }}€
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <x-input-error :messages="$errors->get('membership_id')" class="mt-2" />
                                </div>
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
                                Guardar Cambios
                            </button>
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
