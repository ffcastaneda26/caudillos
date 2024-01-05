<nav x-data="{ open: false }" class="my-fondo-header  dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    @php
        use App\Models\Configuration;
        $configuration_record = Configuration::first();
    @endphp

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-mark class="block h-9 w-auto" />
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                        <label class="my-fondo-header">{{ __('Dashboard') }}</label>
                    </x-nav-link>

                    @include('menus.admin')

                    @include('menus.participant')

                </div>

            </div>

            {{-- Nombre de usuario arriba --}}
            <div class="mr-10 flex items-center justify-end sm:hidden">
                <div class="text-xs">{{ Auth::user()->name }}</div>
              </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Teams Dropdown -->

                @include('auth.teams_dropdown')

                <!-- Settings Dropdown -->
                @include('auth.settings_menu')
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
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
    <div class="container-fluid mt-2">


        <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">


            {{-- Menú del usuario --}}
            <div class="pt-2 pb-3 space-y-1">
                @include('menus.admin_responsive')
                @include('menus.participant_responsive')
            </div>

            <hr>
            <!-- Responsive Settings Options -->
            {{-- @include('auth.settings_responsive_user_name') --}}

            <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div class="mt-3 space-y-1">
                    <!-- Account Management -->
                    <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                        <label class="text-sm">{{ __('Profile') }}</label>
                    </x-responsive-nav-link>

                    @include('auth.apis_menu')

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}" x-data>
                        @csrf

                        <x-responsive-nav-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>

                    <!-- Team Management -->
                    @include('auth.teams_menu')
                </div>
            </div>
        </div>
    </div>
</nav>
