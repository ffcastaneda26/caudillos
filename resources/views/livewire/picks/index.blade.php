<div class="mt-5">
    @livewire('select-round')
    <div class="container-fluid mt-2">
        @if(isset($message))
            <div class="text-red-600 text-danger text-center text-3xl">
                <h1>{{ $message }}</h1>
            </div>
        @endif

        @if(isset($round_games ))
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        Partido Para puntos = {{ $id_game_last_game_round}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-xs">
                                    @include('livewire.picks.header_table')
                                </table>
                                    <tbody>
                                        @foreach ($round_games as $game)
                                            {{-- <input wire:model='gamesids.{{ $loop->index }}' type="text" class="hidden"/>
                                            @include('livewire.picks.pick_list') --}}
                                            @livewire('picks.pick-game',['game'=> $game,
                                                                         'id_game_last_game_round' => $id_game_last_game_round],
                                                                         key($game->id))
                                        @endforeach
                                    </tbody>
                                </table>
                                {{-- <button wire:click="store" class="btn btn-primary float-right">ACTUALIZAR PRONÓSTICOS</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
