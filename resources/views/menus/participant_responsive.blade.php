@auth
    <div class="flex items-start flex-col">
        @if (!Auth::user()->paid && !Auth::user()->hasrole('Admin') && $configuration_record->require_payment_to_continue)
            <my-responsive-nav-link href="{{ route('dashboard') }}" :active="request() - > routeIs('dashboard')">
                <script async src="https://js.stripe.com/v3/buy-button.js"></script>
                <stripe-buy-button buy-button-id="buy_btn_1NhTzSG2UqMVjdJhbchOp1dP"
                    publishable-key="pk_test_51NhHU2G2UqMVjdJhSv2kF1wE7Yc7hJQG93HQsjtGq9QqFaoQiQMYrK7OM5G1NwK1f5PuESMsTO6PspW1rXpwqg5100xgSNl6RB">
                </stripe-buy-button>
            </my-responsive-nav-link>
        @else
            @role('participante')
                @if (!Auth::user()->has_suplementary_data() && $configuration_record->require_data_user_to_continue)
                    <x-my-responsive-nav-link href="{{ route('data-users') }}">
                        Datos Complementarios
                    </x-my-responsive-nav-link>
                @else
                    @if (Route::has('dashboard'))
                        <x-my-responsive-nav-link href="{{ route('dashboard') }}">
                            Paneil Inicial
                        </x-my-responsive-nav-link>
                    @endif

                    @if (Route::has('picks'))
                        <x-my-responsive-nav-link href="{{ route('picks') }}">
                            Pronósticos
                        </x-my-responsive-nav-link>
                    @endif

                    @if (Route::has('results-by-round'))
                        <x-my-responsive-nav-link href="{{ route('results-by-round') }}">
                            Tabla de Pronósticos
                        </x-my-responsive-nav-link>
                    @endif

                    @if (Route::has('positions-by-round'))
                        <x-my-responsive-nav-link href="{{ route('positions-by-round') }}">
                            Posiciones por Jornada
                        </x-my-responsive-nav-link>
                    @endif

                    @if (Route::has('positions-general'))
                        <x-my-responsive-nav-link href="{{ route('positions-general') }}">
                            Posiciones Generales
                        </x-my-responsive-nav-link>
                    @endif

                    @if (Route::has('picks-review'))
                        <my-responsive-nav-link href="{{ route('picks-review') }}"
                            :active="request() - > routeIs('picks-review')">

                            <label class="my-fondo-header">Resultados por Jornada</label>
                        </my-responsive-nav-link>
                    @endif

                    @if (Route::has('data-users'))
                        <x-my-responsive-nav-link href="{{ route('data-users') }}">
                            Posiciones Generales
                        </x-my-responsive-nav-link>
                    @endif
                @endif
            @endrole
        @endif
    </div>
@endauth
