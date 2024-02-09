<thead class="thead">
    <tr class="text-black text-center text-xs" style="background-color: #EAE8E1">

        <th rowspan="2" valign="middle" class="w-25 text-center text-xs">
            PARTICIPANTE
        </th>


        @foreach ($round_games as $game)
            <td class="text-left w-auto">
                <img src="{{ Storage::url($game->visit_team->logo) }}" style="width: 24px">
                vs
                <img src="{{ Storage::url($game->local_team->logo) }}" style="width: 24px">
            </td>
        @endforeach

        <th rowspan="2" valign="middle" class="text-xs">ACIERTOS</th>
    </tr>
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
</thead>

