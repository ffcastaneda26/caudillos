@role('Admin')
    <div class="flex items-start flex-col">
            <x-dropdown align="right" width="30">
                <x-slot name="trigger">
                    <span class="inline-flex rounded-md">
                        <button type="button"
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                            CATALOGOS

                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </button>
                    </span>
                </x-slot>

                <x-slot name="content">
                    <div class="w-30">
                        <!-- Usuarios-->
                        @if (env('MOSTRAR_MENU_USUARIOS', false))
                            <x-my-responsive-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')">
                                {{ __('Users') }}
                            </x-my-responsive-nav-link>
                        @endif

                        <!-- Confituración General-->
                        @if (env('MOSTRAR_MENU_CONFIGURACION', false))
                            <x-my-responsive-nav-link href="{{ route('configurations') }}">
                                Configuración
                            </x-my-responsive-nav-link>
                        @endif


                        @if (env('MOSTRAR_MENU_ENTIDADES', false))
                            <x-my-responsive-nav-link href="{{ route('entidades') }}">
                                Entidades
                            </x-my-responsive-nav-link>
                        @endif

                        @if (env('MOSTRAR_MENU_MUNICIPIOS', false))
                            <x-my-responsive-nav-link href="{{ route('municipios') }}">
                                Municipios
                            </x-my-responsive-nav-link>
                        @endif

                        @if (env('MOSTRAR_MENU_JORNADAS', false))
                            <x-my-responsive-nav-link href="{{ route('rounds') }}">
                                Jornadas
                            </x-my-responsive-nav-link>
                        @endif


                        @if (env('MOSTRAR_MENU_EQUIPOS', false))
                            <x-my-responsive-nav-link href="{{ route('teams') }}">
                                Equipos
                            </x-my-responsive-nav-link>
                        @endif

                    </div>
                </x-slot>
            </x-dropdown>

            @if (Route::has('positions-by-round'))
                <x-my-responsive-nav-link href="{{ route('positions-by-round') }}" class="mt-2" :active="request()->routeIs('positions-by-round')">
                    <label>Posiciones por Jornada</label>
                </x-my-responsive-nav-link>
            @endif


            @if (Route::has('positions-general'))
                <x-my-responsive-nav-link href="{{ route('positions-general') }}" class="mt-2" :active="request()->routeIs('positions-general')">
                    <label>Posiciones Generales</label>
                </x-my-responsive-nav-link>
            @endif

            @if (Route::has('games'))
                <x-my-responsive-nav-link href="{{ route('games') }}" class="mt-2" :active="request()->routeIs('games')">
                    <label>Partidos</label>
                </x-my-responsive-nav-link>
            @endif

    </div>
@endrole
