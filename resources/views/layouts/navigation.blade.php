<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
        <div class="flex justify-between h-14">
            <div class="flex items-center">
                <!-- Logo -->
                <div class="flex items-center shrink-0">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block w-auto text-gray-800 fill-current h-8" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-6 sm:-my-px sm:ms-8 sm:flex">
                    @if (auth()->check() && auth()->user()->role == 'admin')
                        <x-nav-link :href="route('cars')" :active="request()->routeIs('cars')">
                            <span class="text-sm">{{ __('Car Management') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('car-gates')" :active="request()->routeIs('car-gates')">
                            <span class="text-sm">{{ __('Car Gate Management') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('drivers')" :active="request()->routeIs('drivers')">
                            <span class="text-sm">{{ __('Driver Management') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('roles')" :active="request()->routeIs('roles')">
                            <span class="text-sm">{{ __('Role Management') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('offer-things')" :active="request()->routeIs('offer-things')">
                            <span class="text-sm">{{ __('Offer Things Management') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('trips')" :active="request()->routeIs('trips')">
                            <span class="text-sm">{{ __('Trip Management') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('passenger-types')" :active="request()->routeIs('passenger-types')">
                            <span class="text-sm">{{ __('Passenger Type Management') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
                            <span class="text-sm">{{ __('Settings Management') }}</span>
                        </x-nav-link>
                        <x-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                            <span class="text-sm">{{ __('Users Management') }}</span>
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-4">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-500 transition duration-150 ease-in-out bg-white border border-transparent rounded-md hover:text-gray-700 focus:outline-none">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="w-3 h-3 fill-current" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        @if (auth()->check() && auth()->user()->role == 'admin')
                            <x-dropdown-link :href="route('cars')" :active="request()->routeIs('cars')">
                                <span class="text-sm">{{ __('Car Management') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('car-gates')" :active="request()->routeIs('car-gates')">
                                <span class="text-sm">{{ __('Car Gate Management') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('drivers')" :active="request()->routeIs('drivers')">
                                <span class="text-sm">{{ __('Driver Management') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('roles')" :active="request()->routeIs('roles')">
                                <span class="text-sm">{{ __('Role Management') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('offer-things')" :active="request()->routeIs('offer-things')">
                                <span class="text-sm">{{ __('Offer Things Management') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('trips')" :active="request()->routeIs('trips')">
                                <span class="text-sm">{{ __('Trip Management') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('passenger-types')" :active="request()->routeIs('passenger-types')">
                                <span class="text-sm">{{ __('Passenger Type Management') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('settings')" :active="request()->routeIs('settings')">
                                <span class="text-sm">{{ __('Settings Management') }}</span>
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                                <span class="text-sm">{{ __('Users Management') }}</span>
                            </x-dropdown-link>
                        @endif
                        <x-dropdown-link :href="route('profile.edit')">
                            <span class="text-sm">{{ __('Profile') }}</span>
                        </x-dropdown-link>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                <span class="text-sm">{{ __('Log Out') }}</span>
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 text-gray-400 transition duration-150 ease-in-out rounded-md hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500">
                    <svg class="w-5 h-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="sm:hidden">
        <div class="pt-2 pb-3 space-y-1 bg-gray-50">
            @if (auth()->check() && auth()->user()->role == 'admin')
                <x-responsive-nav-link :href="route('cars')" :active="request()->routeIs('cars')">
                    <span class="text-sm">{{ __('Car Management') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('car-gates')" :active="request()->routeIs('car-gates')">
                    <span class="text-sm">{{ __('Car Gate Management') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('drivers')" :active="request()->routeIs('drivers')">
                    <span class="text-sm">{{ __('Driver Management') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('roles')" :active="request()->routeIs('roles')">
                    <span class="text-sm">{{ __('Role Management') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('offer-things')" :active="request()->routeIs('offer-things')">
                    <span class="text-sm">{{ __('Offer Things Management') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('trips')" :active="request()->routeIs('trips')">
                    <span class="text-sm">{{ __('Trip Management') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('passenger-types')" :active="request()->routeIs('passenger-types')">
                    <span class="text-sm">{{ __('Passenger Type Management') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
                    <span class="text-sm">{{ __('Settings Management') }}</span>
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                    <span class="text-sm">{{ __('Users Management') }}</span>
                </x-responsive-nav-link>
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 bg-gray-50">
            <div class="px-4">
                <div class="text-sm font-medium text-gray-800">{{ Auth::user()->name }}</div>
                <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
            </div>
            <div class="mt-3 space-y-1">
                @if (auth()->check() && auth()->user()->role == 'admin')
                    <x-responsive-nav-link :href="route('cars')" :active="request()->routeIs('cars')">
                        <span class="text-sm">{{ __('Car Management') }}</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('car-gates')" :active="request()->routeIs('car-gates')">
                        <span class="text-sm">{{ __('Car Gate Management') }}</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('drivers')" :active="request()->routeIs('drivers')">
                        <span class="text-sm">{{ __('Driver Management') }}</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('roles')" :active="request()->routeIs('roles')">
                        <span class="text-sm">{{ __('Role Management') }}</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('offer-things')" :active="request()->routeIs('offer-things')">
                        <span class="text-sm">{{ __('Offer Things Management') }}</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('trips')" :active="request()->routeIs('trips')">
                        <span class="text-sm">{{ __('Trip Management') }}</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('passenger-types')" :active="request()->routeIs('passenger-types')">
                        <span class="text-sm">{{ __('Passenger Type Management') }}</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('settings')" :active="request()->routeIs('settings')">
                        <span class="text-sm">{{ __('Settings Management') }}</span>
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('users.index')" :active="request()->routeIs('users.index')">
                        <span class="text-sm">{{ __('Users Management') }}</span>
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('profile.edit')">
                    <span class="text-sm">{{ __('Profile') }}</span>
                </x-responsive-nav-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        <span class="text-sm">{{ __('Log Out') }}</span>
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
