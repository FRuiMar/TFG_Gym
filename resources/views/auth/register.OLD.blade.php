<x-guest-layout>

    {{-- <div
        class="w-full sm:max-w-md mt-6 px-6 py-4 bg-gray-600 bg-opacity-70 border-2 border-red-500 shadow-md overflow-hidden sm:rounded-lg"> --}}
    <div
        class="w-full sm:max-w-3xl mt-6 px-8 py-6 bg-gray-600 bg-opacity-80 border-2 border-red-500 shadow-md overflow-hidden sm:rounded-lg">
        <!-- Cabecera con título -->
        <div class="mb-6 text-center">
            <h2 class="mt-3 text-3xl font-bold">
                <span class="text-white">Registro</span>
            </h2>
        </div>

        <form method="POST" action="{{ route('register') }}" class="bg-gray-800 bg-opacity-80 p-6 rounded-lg shadow-xl"
            enctype="multipart/form-data">
            @csrf

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Imagen del usuario -->
                <div class="w-full md:w-1/4 flex flex-col items-center">
                    <div class="mb-4 text-center">
                        <div class="relative w-40 h-40 overflow-hidden bg-gray-700 rounded-full mx-auto">
                            <img id="preview-image" class="w-full h-full object-cover"
                                src="{{ asset('storage/placeholder/user-placeholder.png') }}" alt="Imagen de perfil">
                            <div
                                class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 hover:opacity-100 transition-opacity duration-200">
                                <span class="text-white text-sm font-medium">Cambiar imagen</span>
                            </div>
                            <input type="file" name="image" id="image" accept="image/*"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                                onchange="previewImage()">
                        </div>
                    </div>
                    <p class="text-sm text-gray-400 text-center">Haz clic para subir una imagen (opcional)</p>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <!-- Campos del formulario -->
                <div class="w-full md:w-3/4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- DNI -->
                        <div>
                            <x-input-label for="dni" :value="__('DNI')" class="text-white" />
                            <x-text-input id="dni"
                                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text"
                                name="dni" :value="old('dni')" required autofocus />
                            <x-input-error :messages="$errors->get('dni')" class="mt-2" />
                        </div>

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Nombre')" class="text-white" />
                            <x-text-input id="name"
                                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="text"
                                name="name" :value="old('name')" required />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email')" class="text-white" />
                            <x-text-input id="email"
                                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="email"
                                name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Contraseña')" class="text-white" />
                            <x-text-input id="password"
                                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="password"
                                name="password" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" class="text-white" />
                            <x-text-input id="password_confirmation"
                                class="block mt-1 w-full bg-gray-700 border-gray-600 text-white" type="password"
                                name="password_confirmation" required autocomplete="new-password" />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>
                    </div>

                    <!-- Membership -->
                    <div class="mt-4">
                        <x-input-label for="membership_id" :value="__('Membresía')" class="text-white" />
                        <select id="membership_id" name="membership_id"
                            class="block mt-1 w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                            <option value="">Sin membresía</option>
                            @foreach ($memberships as $membership)
                                <option value="{{ $membership->id }}">{{ $membership->type }} -
                                    {{ $membership->price }}€
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('membership_id')" class="mt-2" />
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-8">
                <a class="text-sm text-gray-300 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 focus:ring-offset-gray-800"
                    href="{{ route('login') }}">
                    {{ __('¿Ya tienes cuenta? Iniciar sesión') }}
                </a>

                <button type="submit"
                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    {{ __('Registrarse') }}
                </button>
            </div>
        </form>
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
</x-guest-layout>
