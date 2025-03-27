<x-guest-layout>
    <div
        class="w-full sm:max-w-3xl mt-6 px-8 py-6 bg-white bg-opacity-30 border-2 border-red-500 shadow-md overflow-hidden sm:rounded-lg">
        <div class="mb-4 p-4 bg-gray-800 bg-opacity-80 text-lg text-white dark:text-white">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 px-4 py-1 bg-green-600 bg-opacity-80 font-medium text-lg text-green-600 dark:text-white">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ __('Resend Verification Email') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                    class="px-2 py-1 underline bg-red-500 text-base text-white dark:text-white hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
