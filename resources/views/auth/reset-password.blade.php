<x-guest-layout>
    <div
        class="w-full sm:max-w-3xl mt-6 px-8 py-6 bg-gray-800 bg-opacity-60 border-2 border-red-500 shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 p-4 bg-gray-800 bg-opacity-80 text-lg text-white dark:text-white">
            {{ __('Reset your password.') }}
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input id="email"
                    class="block mt-1 w-full p-2 bg-gray-800 bg-opacity-80 text-white border border-gray-700 rounded-md focus:border-red-500 focus:ring-red-500"
                    type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" class="text-white" />
                <x-text-input id="password"
                    class="block mt-1 w-full p-2 bg-gray-800 bg-opacity-80 text-white border border-gray-700 rounded-md focus:border-red-500 focus:ring-red-500"
                    type="password" name="password" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
                <x-text-input id="password_confirmation"
                    class="block mt-1 w-full p-2 bg-gray-800 bg-opacity-80 text-white border border-gray-700 rounded-md focus:border-red-500 focus:ring-red-500"
                    type="password" name="password_confirmation" required autocomplete="new-password" />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
