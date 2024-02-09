<div>
    @livewire('select-round')

    <div class="container-fluid mt-2">
        @if (isset($round_games) && !empty($round_games))
            <div class="flex flex-row justify-center">
                <div class="card">
                    {{-- Buscar --}}

                    @include('livewire.results.search')

                    <div class="card-body ">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table text-xs">
                                    @include('livewire.results.header_game_teams')
                                    <tbody>
                                        {{-- Datos del usuario conectado --}}
                                        @if (env('SHOW_PICK_AUTH_USER_DETAIL_FIRST', false))
                                            @include('livewire.results.picks_auth_user')
                                        @endif

                                        @foreach ($records as $pick_user)
                                            @include('livewire.results.list')
                                        @endforeach
                                    </tbody>
                                </table>
                                @include('common.crud_pagination')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
