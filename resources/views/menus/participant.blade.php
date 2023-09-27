@auth
    @if(!Auth::user()->paid && !Auth::user()->hasrole('Admin')  &&  $configuration_record->require_payment_to_continue)
        <x-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
            <script async   src="https://js.stripe.com/v3/buy-button.js"> </script>
            <stripe-buy-button
                buy-button-id="buy_btn_1NhTzSG2UqMVjdJhbchOp1dP"
                publishable-key="pk_test_51NhHU2G2UqMVjdJhSv2kF1wE7Yc7hJQG93HQsjtGq9QqFaoQiQMYrK7OM5G1NwK1f5PuESMsTO6PspW1rXpwqg5100xgSNl6RB"
            >
            </stripe-buy-button>
        </x-nav-link>
    @else

        @role('participante')
            @if(!Auth::user()->has_suplementary_data() &&  $configuration_record->require_data_user_to_continue)
                <x-nav-link href="{{ route('data-users') }}" :active="request()->routeIs('data-users')">
                    Datos Complementarios
                </x-nav-link>
            @else

                {{-- @if (Route::has('games'))
                    <x-nav-link href="{{ route('games') }}" :active="request()->routeIs('games')">
                        Partidos
                    </x-nav-link>
                @endif --}}

                @if (Route::has('picks'))
                    <x-nav-link href="{{ route('picks') }}" :active="request()->routeIs('picks')">
                        Pronósticos
                    </x-nav-link>
                @endif

                @if (Route::has('results-by-round'))
                    <x-nav-link href="{{ route('results-by-round') }}" :active="request()->routeIs('results-by-round')">
                        Tabla de Pronósticos
                    </x-nav-link>
                @endif

                @if (Route::has('positions-by-round'))
                    <x-nav-link href="{{ route('positions-by-round') }}" :active="request()->routeIs('positions-by-round')">
                        Posiciones por Jornada
                    </x-nav-link>
                @endif

                @if (Route::has('positions-general'))
                    <x-nav-link href="{{ route('positions-general') }}" :active="request()->routeIs('positions-general')">
                        Posiciones Generales
                    </x-nav-link>
                @endif

                @if (Route::has('picks-review'))
                    <x-nav-link href="{{ route('picks-review') }}" :active="request()->routeIs('picks-review')">
                        Resultados por Jornada
                    </x-nav-link>
                @endif

                @if (Route::has('data-users'))
                    <x-nav-link href="{{ route('data-users') }}" :active="request()->routeIs('data-users')">
                        Datos Complementarios
                    </x-nav-link>
                @endif
            @endif

        @endrole

    @endif

@endauth
