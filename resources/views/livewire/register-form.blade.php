<div class="bg-gray-800 bg-opacity-80 p-6 rounded-lg shadow-xl">
    <form wire:submit="register" enctype="multipart/form-data">
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Imagen del usuario -->
            <div class="w-full md:w-1/4 flex flex-col items-center">
                <div class="mb-4 text-center">
                    <div class="relative w-40 h-40 overflow-hidden bg-gray-700 rounded-full mx-auto">
                        @if ($image)
                            <img class="w-full h-full object-cover" src="{{ $image->temporaryUrl() }}"
                                alt="Imagen de perfil">
                        @else
                            <img class="w-full h-full object-cover"
                                src="{{ asset('storage/placeholder/user-placeholder.png') }}" alt="Imagen de perfil">
                        @endif
                        <div
                            class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
                            <span class="text-white text-sm font-medium">Cambiar imagen</span>
                        </div>
                        <input type="file" wire:model.live="image" accept="image/*"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                    </div>
                </div>
                <p class="text-sm text-gray-400 text-center">Haz clic para subir una imagen (opcional)</p>
                @error('image')
                    <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                @enderror
            </div>

            <!-- Campos del formulario -->
            <div class="w-full md:w-3/4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- DNI -->
                    <div>
                        <label for="dni" class="block text-white">DNI</label>
                        <input id="dni" type="text" wire:model.live="dni"
                            class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md" required
                            autofocus>
                        @error('dni')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Nombre -->
                    <div>
                        <label for="name" class="block text-white">Nombre</label>
                        <input id="name" type="text" wire:model.live="name"
                            class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md" required>
                        @error('name')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-white">Email</label>
                        <input id="email" type="email" wire:model.live="email"
                            class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md" required>
                        @error('email')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Membresía -->
                    <div>
                        <label for="membership_id" class="block text-white">Membresía</label>
                        <select id="membership_id" wire:model.live="membership_id"
                            class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md" required>
                            <option value="">Selecciona una membresía</option>
                            @foreach ($memberships as $membership)
                                <option value="{{ $membership->id }}">{{ $membership->type }} -
                                    {{ number_format($membership->price, 2) }}€</option>
                            @endforeach
                        </select>
                        @error('membership_id')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div>
                        <label for="password" class="block text-white">Contraseña</label>
                        <input id="password" type="password" wire:model.live="password"
                            class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md" required>
                        @error('password')
                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div>
                        <label for="password_confirmation" class="block text-white">Confirmar Contraseña</label>
                        <input id="password_confirmation" type="password" wire:model.live="password_confirmation"
                            class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md" required>
                    </div>
                </div>

                <div class="flex items-center justify-between mt-6">
                    <!-- Botón para volver a la página de bienvenida -->
                    <a href="/"
                        class="px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                        <span class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Volver
                        </span>
                    </a>

                    <div class="flex items-center">
                        <a class="underline text-sm text-gray-400 hover:text-gray-200" href="{{ route('login') }}">
                            ¿Ya registrado?
                        </a>

                        <button type="submit"
                            class="ml-4 px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            Registrarse
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
