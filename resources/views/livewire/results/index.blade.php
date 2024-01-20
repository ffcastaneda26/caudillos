<div>
    @livewire('select-round')

    <div class="container-fluid mt-2">
        @if (isset($round_games) && !empty($round_games))
            <div class="flex flex-row justify-center">
                <div class="col-sm-7">
                    <div class="row mb-2">
                        <div class="flex flex-row justify-between">
                            <div class="search-bar">
                                <input wire:model="search"
                                    class="search-input form-control rounded"
                                    placeholder="{{ __($search_label) }}">
                            </div>
                        </div>

                    </div>

                    {{-- Partidos y resultados --}}
                    <div class="table-responsive">
                        <table class="table text-xs">
                            @include('livewire.results.header_game_teams')

                            <tbody>
                                {{isset($records) &&  $records->count() ?  $records->count() : 'NO HAY USUARIOS' }}
                                @foreach ($records as $pick_user)
                                    <tr>
                                        <td>{{ $pick_user->name }}</td>
                                        {{-- @dd('Pronosticos del usario',$selected_round->picks_user($pick_user->id)->get()->count()) --}}

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
