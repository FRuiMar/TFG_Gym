<section>
    <div
        class="w-full max-w-5xl mx-auto mt-6 px-8 py-6 bg-gray-600 bg-opacity-80 border-2 border-red-500 shadow-md overflow-hidden sm:rounded-lg">
        <header class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-white">
                {{ __('Update Password') }}
            </h2>
            <p class="mt-2 text-sm text-gray-300">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </header>

        <form method="post" action="{{ route('password.update') }}"
            class="bg-gray-800 bg-opacity-80 p-6 rounded-lg shadow-xl">
            @csrf
            @method('put')

            <div>
                <x-input-label for="update_password_current_password" :value="__('Current Password')" class="text-white" />
                <x-text-input id="update_password_current_password" name="current_password" type="password"
                    class="mt-2 block w-full bg-gray-700 border-gray-600 text-white" autocomplete="current-password" />
                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password" :value="__('New Password')" class="text-white" />
                <x-text-input id="update_password_password" name="password" type="password"
                    class="mt-2 block w-full bg-gray-700 border-gray-600 text-white" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="update_password_password_confirmation" :value="__('Confirm Password')" class="text-white" />
                <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password"
                    class="mt-2 block w-full bg-gray-700 border-gray-600 text-white" autocomplete="new-password" />
                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end gap-4 pt-6 mt-6 border-t border-gray-700">
                @if (session('status') === 'password-updated')
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
