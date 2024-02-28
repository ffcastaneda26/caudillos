<tr>
    <td align="left">{{ $user->name }}</td>

    @foreach ($selected_round->picks_user($user->id)->get() as $pick)
        @php
            $pick_game  = $pick->game;
            $allow_pick = $pick_game->allow_pick();
            $has_result = $pick_game->has_result();
            $hit_game   = $pick->winner == $pick_game->winner;
        @endphp
        <td align="center">
            @if ($allow_pick)
                <x-reloj-image />
            @else
                @if ($pick->winner == 1)
                    <img src="{{ Storage::url($pick->game->local_team->logo) }}" width="24px">
                @else
                    <img src="{{ Storage::url($pick->game->visit_team->logo) }}" width="24px">
                @endif

                @if ($has_result)
                    @include('livewire.results.list_hit_game_icon')
                @endif
            @endif
        </td>

        @php
            // Si es el juego de desempate lee el pronóstico y revisa si acertó o no
            if($pick->game_id === $tie_breaker_game->id){
                // $tie_breaker_game_pick_user     = $tie_breaker_game->pick_user($user->id);
                // $tie_breaker_game_hit_by_user = $tie_breaker_game_pick_user->winner === $tie_breaker_game->winner;
                $tie_breaker_game_pick_user = $pick;
                $tie_breaker_game_hit_by_user = $hit_game;
            }
        @endphp
    @endforeach

    @include('livewire.results.list_tie_breaker_column')

    @if($round_has_games_played)
            @if($sort == 'name')
                @php
                    $user_posicion_record__round = $user->read_position_record_round($selected_round->id);
                @endphp
                <td class="text-center">
                    {{ $user_posicion_record__round->hits }}
                </td>
                <td class="text-center">
                    {{ $user_posicion_record__round->total_points }}
                </td>
            @else
                <td>{{ $user->hits }}</td>
                <td>{{ $user->total_points }}</td>
            @endif

     @endif
</tr>
