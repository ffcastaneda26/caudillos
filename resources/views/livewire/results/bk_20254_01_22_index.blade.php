<div>
    @livewire('select-round')

    <div class="container-fluid mt-2">
        @if (isset($round_games) && !empty($round_games))
            <div class="flex flex-row justify-center">
                <div class="col-sm-7">
                    {{-- <div class="row mb-2">
                        <div class="flex flex-row justify-between">
                            <div class="search-bar">
                                <input wire:model.defer="search"
                                    class="search-input form-control rounded"
                                    placeholder="{{ __($search_label) }}">
                            </div>

                                <span>
                                    <button class="btn btn-success" wire:click="$refresh">Busca</button>
                                </span>

                        </div>

                    </div> --}}

                    {{-- Partidos y resultados --}}
                    <div class="table-responsive">
                        <table class="table text-xs">
                            @include('livewire.results.header_game_teams')

                            <tbody>
                                {{-- Datos del usuario conectado --}}
                                <tr>
                                    <td class="bg-success text-white  text-xs">
                                        {{ Auth::user()->name}}
                                    </td>
                                    @foreach($picks_auth_user_round as $pick_auth_user)
                                        @livewire('user-pick-game', ['pick' => $pick_auth_user], key($pick_auth_user->user_id))
                                    @endforeach
                                </tr>
                                {{-- {{isset($records) &&  $records->count() ?  $records->count() : 'NO HAY USUARIOS' }} --}}
                                @foreach ($records as $pick_user)
                                    <tr>
                                        <td>{{ $pick_user->name }}</td>

                                        @foreach ($selected_round->picks_user($pick_user->id)->get() as $pick)
                                            @livewire('user-pick-game', ['pick' => $pick], key($pick->id))
                                        @endforeach

                                        <td class="text-base text-center">
                                            {{ $pick_user->has_position_record_round($selected_round->id) ? $pick_user->hits_round($selected_round->id) : '' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>

                        </table>
                        @include('common.crud_pagination')
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
