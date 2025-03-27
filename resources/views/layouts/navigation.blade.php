<nav x-data="{ open: false }" class="bg-gray-800 bg-opacity-80 border-b border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="container mx-auto px-4">
        <div class="flex justify-between h-20">
            <!-- PARTE IZQUIERDA: Logo, título y Panel de Control -->
            <div class="flex items-center space-x-8"> <!-- Añadido space-x-8 para separar logo y enlace -->
                <!-- Logo y título -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center">
                        <img src="{{ asset('storage/logo/Forza64_2.png') }}" alt="Forza Training Center Logo"
                            class="h-12 w-auto">
                        <span class="text-2xl font-bold ml-3">
                            <span class="text-red-500">Forza</span> <span class="text-white">Training Center</span>
                        </span>
                    </a>
                </div>

                <!-- Panel de Control a la izquierda -->
                <div class="hidden sm:flex items-center">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" class="text-gray-300 hover:text-white text-lg">
                        {{ __('Panel de Control') }}
                    </x-nav-link>
                </div>
            </div>


            <!-- PARTE CENTRAL: Enlaces de navegación -->
            <div class="flex-1 flex justify-center items-center"> <!-- Nuevo div central con justify-center -->
                <div class="hidden sm:flex space-x-6"> <!-- Reducido espaciado para acomodar más enlaces -->
                    @if (Auth::user()->role === 'ADMIN')
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')" class="text-gray-300 hover:text-white text-lg">
                            {{ __('Usuarios') }}
                        </x-nav-link>
                        <x-nav-link :href="route('memberships.index')" :active="request()->routeIs('memberships.*')" class="text-gray-300 hover:text-white text-lg">
                            {{ __('Membresías') }}
                        </x-nav-link>
                        <x-nav-link :href="route('trainers.index')" :active="request()->routeIs('trainers.*')" class="text-gray-300 hover:text-white text-lg">
                            {{ __('Entrenadores') }}
                        </x-nav-link>
                        <x-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.*')" class="text-gray-300 hover:text-white text-lg">
                            {{ __('Actividades') }}
                        </x-nav-link>
                        <x-nav-link :href="route('user.admin.reservations')" :active="request()->routeIs('user.admin.reservations')"
                            class="text-gray-300 hover:text-white text-lg">
                            {{ __('Reservas') }}
                        </x-nav-link>
                    @elseif(Auth::user()->role === 'NORMAL')
                        <x-nav-link :href="route('activities.user-cards')" :active="request()->routeIs('activities.user-cards')"
                            class="text-gray-300 hover:text-white text-lg">
                            {{ __('Ver Actividades') }}
                        </x-nav-link>
                        <x-nav-link :href="route('user.reservations')" :active="request()->routeIs('user.reservations')"
                            class="text-gray-300 hover:text-white text-lg">
                            {{ __('Mis Reservas') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- PARTE DERECHA: Settings Dropdown -->
            <div class="flex items-center">
                <div class="hidden sm:flex sm:items-center">
                    @if (Auth::user()->role === 'ADMIN')
                        <span class="mr-2 text-red-500 text-xl font-bold">(ADMIN)</span>
                    @endif
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button
                                class="inline-flex items-center px-4 py-2.5 border border-transparent text-base font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none transition ease-in-out duration-150">
                                <div>{{ Auth::user()->name }}</div>

                                <div class="ms-1">
                                    <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden ml-4">
                    <button @click="open = ! open"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:bg-gray-700 focus:text-white transition duration-150 ease-in-out">
                        <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                            <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden"
                                stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            @if (Auth::user()->role === 'ADMIN')
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.*')">
                    {{ __('Usuarios') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('memberships.index')" :active="request()->routeIs('memberships.*')">
                    {{ __('Membresías') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('trainers.index')" :active="request()->routeIs('trainers.*')">
                    {{ __('Entrenadores') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('activities.index')" :active="request()->routeIs('activities.*')">
                    {{ __('Actividades') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('user.admin.reservations')" :active="request()->routeIs('user.admin.reservations')">
                    {{ __('Reservas') }}
                </x-responsive-nav-link>
            @elseif(Auth::user()->role === 'NORMAL')
                <x-responsive-nav-link :href="route('user.reservations')" :active="request()->routeIs('user.reservations')">
                    {{ __('Mis Reservas') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('activities.user-cards')" :active="request()->routeIs('activities.user-cards')">
                    {{ __('Ver Actividades') }}
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
