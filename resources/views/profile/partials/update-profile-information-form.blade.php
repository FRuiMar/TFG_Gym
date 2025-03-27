<section>
    <div
        class="w-full max-w-5xl mx-auto mt-6 px-8 py-6 bg-gray-600 bg-opacity-80 border-2 border-red-500 shadow-md overflow-hidden sm:rounded-lg">
        <header class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-white">
                {{ __('Profile Information') }}
            </h2>
            <p class="mt-2 text-sm text-gray-300">
                {{ __("Update your account's profile information and email address.") }}
            </p>
        </header>

        <form method="post" action="{{ route('profile.update') }}"
            class="bg-gray-800 bg-opacity-80 p-6 rounded-lg shadow-xl" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="flex flex-col md:flex-row gap-16">
                <!-- Columna izquierda: Foto de perfil -->
                <div class="w-full md:w-1/4">
                    <div class="flex flex-col items-center">
                        <div class="mb-4 relative w-48 h-48 rounded-full overflow-hidden bg-gray-700 shadow-md">
                            @if ($user->image)
                                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                                    class="w-full h-full object-cover">
                            @else
                                <div class="flex items-center justify-center w-full h-full bg-gray-600">
                                    <svg class="w-24 h-24 text-gray-400" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <label for="image" class="block text-sm font-medium text-gray-300 mb-2">
                            {{ __('Profile Picture') }}
                        </label>
                        <input type="file" id="image" name="image" accept="image/*"
                            class="block w-full text-sm text-gray-300
                                   file:mr-4 file:py-2 file:px-4
                                   file:rounded-md file:border-0
                                   file:text-sm file:font-semibold
                                   file:bg-red-50 file:text-red-700
                                   hover:file:bg-red-100
                                   dark:file:bg-red-900 dark:file:text-red-100
                                   dark:hover:file:bg-red-800" />
                        <x-input-error class="mt-2" :messages="$errors->get('image')" />
                    </div>
                </div>

                <!-- Columna derecha: Información del perfil -->
                <div class="w-full md:w-3/4 md:pl-8 md:border-l md:border-gray-700">
                    <div class="space-y-5">
                        <div>
                            <x-input-label for="name" :value="__('Name')" class="text-white" />
                            <x-text-input id="name" name="name" type="text"
                                class="mt-2 block w-full bg-gray-700 border-gray-600 text-white" :value="old('name', $user->name)"
                                required autofocus autocomplete="name" />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <div class="pt-2">
                            <x-input-label for="email" :value="__('Email')" class="text-white" />
                            <x-text-input id="email" name="email" type="email"
                                class="mt-2 block w-full bg-gray-700 border-gray-600 text-white" :value="old('email', $user->email)"
                                required autocomplete="username" />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                                <div>
                                    <p class="text-sm mt-2 text-gray-300">
                                        {{ __('Your email address is unverified.') }}

                                        <button form="send-verification"
                                            class="underline text-sm text-gray-400 hover:text-white">
                                            {{ __('Click here to re-send the verification email.') }}
                                        </button>
                                    </p>

                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-2 font-medium text-sm text-green-400">
                                            {{ __('A new verification link has been sent to your email address.') }}
                                        </p>
                                    @endif
                                </div>
                            @endif
                        </div>

                        <!-- Membresía -->
                        <div class="pt-2">
                            <x-input-label for="membership_id" :value="__('Membership')" class="text-white" />
                            <select id="membership_id" name="membership_id"
                                class="mt-2 block w-full bg-gray-700 border-gray-600 text-white rounded-md shadow-sm focus:border-red-500 focus:ring-red-500">
                                <option value="">{{ __('Select a membership') }}</option>
                                @foreach ($memberships as $membership)
                                    <option value="{{ $membership->id }}"
                                        {{ old('membership_id', $user->membership_id) == $membership->id ? 'selected' : '' }}>
                                        {{ $membership->type }} - {{ number_format($membership->price, 2) }}€
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('membership_id')" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-gray-700">


                @if (session('status') === 'profile-updated')
                    <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                        class="text-2xl text-green-400">{{ __('Saved.') }}</p>
                @endif

                <x-primary-button class="bg-red-600 hover:bg-red-700 focus:bg-red-700">
                    {{ __('Save') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</section>
