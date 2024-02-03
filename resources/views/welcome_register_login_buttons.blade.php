@if (Route::has('login'))
    <div class="text-center p-2">
        @auth
            <a href="{{ url('/dashboard') }}"
                class="font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                Dashboard
            </a>
        @else

            <div class="flex flex-row justify-center md:justify-between justify-items-center gap-40">
                <div class="flex flex-col items-center md:flex-row md:justify-between gap-4 md:gap-40">
                    <x-register class="mb-4 md:mb-0" />

                    <img class="rounded-xs" src="{{ asset('images/patrocinios/tdxcausa.png') }}" alt="Logo" width="100px" height="150px">

                    <x-login class="mt-4 md:mt-0" />
                </div>
            </div>
        @endauth
    </div>
@endif
