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
                                            @php
                                                $visit_points = null;
                                                $local_points = null;
                                                $hit_mnf_game = false;
                                                $allow_pick = false;
                                            @endphp
                                            <tr>
                                                <td align="left">{{ $pick_user->name }}</td>

                                                @foreach ($selected_round->picks_user($pick_user->id)->get() as $pick)
                                                    @php
                                                        $pick_game = $pick->game;
                                                        $user_picks = $pick_user->picks_game($pick_game->id)->first();
                                                        $allow_pick = $pick_game->allow_pick();
                                                        $has_result = $pick_game->has_result();
                                                        $hit_game = $pick->winner == $pick_game->winner;
                                                    @endphp
                                                    <td align="center">
                                                        @if ($allow_pick)
                                                            <x-reloj-image />
                                                        @else
                                                            @if ($pick->winner == 1)
                                                                <img src="{{ Storage::url($pick->game->local_team->logo) }}" class="avatar-xs">
                                                            @else
                                                                <img src="{{ Storage::url($pick->game->visit_team->logo) }}" class="avatar-xs">
                                                            @endif

                                                            @if ($has_result)
                                                                <span>
                                                                    <img src="{{ $hit_game ? asset('images/afirmativo.png') : asset('images/negativo.png') }}"
                                                                        height="10px" width="10px">
                                                                </span>
                                                            @endif
                                                        @endif
                                                    </td>

                                                    @php
                                                        $visit_points = $pick->visit_points;
                                                        $local_points = $pick->local_points;
                                                        $hit_last_game = $pick->winner == $pick->game->winner;
                                                        $allow_pick = $pick->game->allow_pick($configuration->minuts_before_picks);
                                                    @endphp
                                                @endforeach
                                                <td class="text-center {{ $hit_last_game ? 'text-success' : 'text-danger' }}">
                                                    @if ($allow_pick)
                                                        <x-reloj-image-12px />

                                                     @else
                                                        {{ $visit_points . '-' . $local_points }}
                                                    @endif
                                                </td>

                                                <td class="text-center">
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
                </div>
            </div>
        @endif
    </div>
</div>
