@role('Admin')
    @if(env('MOSTRAR_MENU_USUARIOS',false))
        <x-nav-link href="{{ route('users') }}" :active="request()->routeIs('users')">
            Usuarios
        </x-nav-link>
    @endif

    @if(env('MOSTRAR_MENU_CONFIGURACION',false))
        <x-nav-link href="{{ route('configurations') }}" :active="request()->routeIs('configurations')">
            Configuración
        </x-nav-link>
    @endif


    @if(env('MOSTRAR_MENU_ENTIDADES',false))
        <x-nav-link href="{{ route('entidades') }}" :active="request()->routeIs('entidades')">
            Entidades
        </x-nav-link>
    @endif

    @if (env('MOSTRAR_MENU_MUNICIPIOS',false))
        <x-nav-link href="{{ route('municipios') }}" :active="request()->routeIs('municipios')">
            Municipios
        </x-nav-link>
    @endif

    @if(env('MOSTRAR_MENU_JORNADAS',false))
        <x-nav-link href="{{ route('rounds') }}" :active="request()->routeIs('rounds')">
            Jornadas
        </x-nav-link>
    @endif


    @if(env('MOSTRAR_MENU_EQUIPOS',false))
        <x-nav-link href="{{ route('teams') }}" :active="request()->routeIs('teams')">
            Equipos
        </x-nav-link>
    @endif


    <x-nav-link href="{{ route('games') }}" :active="request()->routeIs('games')">
        Partidos
    </x-nav-link>

@endrole
