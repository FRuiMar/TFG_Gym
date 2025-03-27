<x-guest-layout>
    <div
        class="w-full sm:max-w-3xl mt-6 px-8 py-6 bg-white bg-opacity-30 border-2 border-red-500 shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 p-4 bg-gray-800 bg-opacity-80 text-lg text-white dark:text-white">
            {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
        </div>

        <!-- Session Status -->
        <x-auth-session-status
            class="mb-4 px-4 py-1 bg-green-600 bg-opacity-80 font-medium text-lg text-green-600 dark:text-white"
            :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <!-- Email Address -->
            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" class="text-white" />
                <x-text-input id="email"
                    class="block mt-1 w-full p-2 bg-gray-800 bg-opacity-80 text-white border border-gray-700 rounded-md focus:border-red-500 focus:ring-red-500"
                    type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
            </div>

            <div class="flex items-center justify-between mt-4">
                <!-- Botón para volver a la página de inicio -->
                <a href="{{ route('login') }}"
                    class="px-4 py-2 bg-gray-700 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    {{ __('Back to Login') }}
                </a>

                <x-primary-button
                    class="px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                    {{ __('Email Password Reset Link') }}
                </x-primary-button>
            </div>
        </form>
    </div>
</x-guest-layout>
