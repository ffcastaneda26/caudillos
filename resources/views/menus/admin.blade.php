@role('Admin')
        <div class="mt-3 relative">
            <x-dropdown align="right" width="30">

                <x-slot name="trigger">
                    <span class="inline-flex rounded-md">
                        <button type="button"
                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none focus:bg-gray-50 dark:focus:bg-gray-700 active:bg-gray-50 dark:active:bg-gray-700 transition ease-in-out duration-150">
                            CATALOGOS
                            <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                            </svg>
                        </button>
                    </span>
                </x-slot>

                <x-slot name="content">
                    <div class="w-30">
                        <!-- Usuarios-->
                        @if(env('MOSTRAR_MENU_USUARIOS',false))
                            <x-dropdown-link href="{{ route('users') }}">
                                Usuarios
                            </x-dropdown-link>
                        @endif

                        <!-- Confituración General-->
                        @if(env('MOSTRAR_MENU_CONFIGURACION',false))
                            <x-dropdown-link href="{{ route('configurations') }}">
                                Configuración
                            </x-dropdown-link>
                        @endif


                        @if(env('MOSTRAR_MENU_ENTIDADES',false))
                            <x-dropdown-link href="{{ route('entidades') }}">
                                Entidades
                            </x-dropdown-link>
                        @endif

                        @if (env('MOSTRAR_MENU_MUNICIPIOS',false))
                            <x-dropdown-link href="{{ route('municipios') }}">
                                Municipios
                            </x-dropdown-link>
                        @endif

                        @if(env('MOSTRAR_MENU_JORNADAS',false))
                            <x-dropdown-link href="{{ route('rounds') }}">
                                Jornadas
                            </x-dropdown-link>
                        @endif


                        @if(env('MOSTRAR_MENU_EQUIPOS',false))
                            <x-dropdown-link href="{{ route('teams') }}">
                                Equipos
                            </x-dropdown-link>
                        @endif

                    </div>
                </x-slot>
            </x-dropdown>
        </div>



    @if (Route::has('positions-by-round'))
        <x-nav-link id="position_by_round" href="{{ route('positions-by-round') }}" :active="request()->routeIs('positions-by-round')">

            <label for="position_by_round" class="my-fondo-header">Posiciones por Jornada</label>
        </x-nav-link>
    @endif

    @if (Route::has('positions-general'))
        <x-nav-link id="position_general" href="{{ route('positions-general') }}" :active="request()->routeIs('positions-general')">
            <label  for="position_general" class="my-fondo-header">Posiciones Generales</label>
        </x-nav-link>
    @endif


    <x-nav-link id="games" href="{{ route('games') }}" :active="request()->routeIs('games')">
        <label for="games" class="my-fondo-header">Partidos</label>
    </x-nav-link>

@endrole
