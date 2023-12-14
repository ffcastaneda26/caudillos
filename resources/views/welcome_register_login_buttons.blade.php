@if (Route::has('login'))
    <div class="text-center p-2">
        @auth
            <a href="{{ url('/dashboard') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Dashboard
            </a>
        @else
            <div class="flex flex-row  justify-center justify-items-center gap-40">
                <x-register />

                <x-login />
            </div>
        @endauth
    </div>
@endif
