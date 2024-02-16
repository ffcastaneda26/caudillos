<thead class="thead">
    <tr class="text-black text-center text-xs" style="background-color: #EAE8E1">

        <th rowspan="2" valign="middle" class="w-25 text-center text-xs">
            PARTICIPANTE
        </th>


        @foreach ($round_games as $game)
            <td class="text-left w-auto">
                <img src="{{ Storage::url($game->visit_team->logo) }}" style="width: 24px">
                <br>
                <img src="{{ Storage::url($game->local_team->logo) }}" style="width: 24px">
            </td>
        @endforeach


        <th rowspan="2"valign="middle" class="text-xs">
            <img src="{{ asset('images/tie_breaker_game_icon.png') }}"width="25" height="25">
        </th>

        @if($round_has_games_played)
            <th rowspan="2" valign="middle" align="center" class="text-xs">
                <img src="{{ asset('images/afirmativo.png') }}" height="16px" width="16px">
            </th>
            <th rowspan="2" valign="middle" align="center" class="text-xs">PTS</th>
        @endif

    </tr>
    @if($round_has_games_played)
        <tr class="fondo-azul text-white text-left text-xs">
            @foreach ($round_games as $game)
                <td>
                    @if ($game->visit_points || $game->local_pints)
                        {{ $game->visit_points ? $game->visit_points : '0' }}
                        <br>
                        {{ $game->local_points ? $game->local_points : '0' }}
                    @endif
                </td>
            @endforeach
        </tr>
    @endif
</thead>

