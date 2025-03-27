<section>
    <div
        class="w-full max-w-5xl mx-auto mt-6 px-8 py-6 bg-gray-600 bg-opacity-80 border-2 border-red-500 shadow-md overflow-hidden sm:rounded-lg">
        <header class="mb-6 text-center">
            <h2 class="text-3xl font-bold text-white">
                {{ __('Delete Account') }}
            </h2>
            <p class="mt-2 text-sm text-gray-300">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
            </p>
        </header>

        <x-danger-button x-data="" x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="mt-4 bg-red-600 hover:bg-red-700 focus:bg-red-700">
            {{ __('Delete Account') }}
        </x-danger-button>

        <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
            <form method="post" action="{{ route('profile.destroy') }}"
                class="p-6 bg-gray-800 bg-opacity-80 rounded-lg shadow-xl">
                @csrf
                @method('delete')

                <h2 class="text-3xl font-bold text-white text-center">
                    {{ __('Are you sure you want to delete your account?') }}
                </h2>

                <p class="mt-2 text-sm text-gray-300 text-center">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>

                <div class="mt-6">
                    <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                    <x-text-input id="password" name="password" type="password"
                        class="mt-1 block w-full bg-gray-700 border-gray-600 text-white"
                        placeholder="{{ __('Password') }}" />

                    <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
                </div>

                <div class="mt-6 flex justify-end gap-4">
                    <x-secondary-button x-on:click="$dispatch('close')" class="bg-gray-600 hover:bg-gray-700">
                        {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-danger-button class="bg-red-600 hover:bg-red-700 focus:bg-red-700">
                        {{ __('Delete Account') }}
                    </x-danger-button>
                </div>
            </form>
        </x-modal>
    </div>
</section>
