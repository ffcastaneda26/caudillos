<!-- Settings Dropdown -->
<div class="ml-3 relative">
    <x-dropdown align="right" width="64">
        <x-slot name="trigger">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <button
                    class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                        alt="{{ Auth::user()->name }}" />
                </button>
            @else
                <span class="inline-flex rounded-md">
                    <button type="button"
                        class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                        {{ Auth::user()->name }}

                        <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                        </svg>
                    </button>
                </span>
            @endif
        </x-slot>

        <x-slot name="content">
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Manage Account') }}
            </div>

            <x-dropdown-link id="profile_user_url" href="{{ route('profile.show') }}">
                <i class="fa-regular fa-user"></i>
                <label for="profile_user_url" class="ml-2">{{ __('Profile') }}</label>
            </x-dropdown-link>

            @if (Auth::user()->has_suplementary_data())
                <x-dropdown-link id="profile_user_url" href="{{ route('data-users') }}">
                    <i class="fa-regular fa-circle-user"></i>
                    <label for="profile_user_url" class="ml-2 text-xs">Datos Complementarios</label>
                </x-dropdown-link>
            @endif

            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                </x-dropdown-link>
            @endif

            <div class="border-t border-gray-200 dark:border-gray-600"></div>

            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <x-dropdown-link id="logout_user_url" href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    <label for="logout_user_url" class="text-sm mr-5">{{ __('Log Out') }}</label>
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </x-dropdown-link>
            </form>
        </x-slot>
    </x-dropdown>
</div>
