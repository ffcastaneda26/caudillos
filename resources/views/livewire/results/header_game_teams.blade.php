<thead class="thead">
    <tr class="text-black text-center text-sm" style="background-color: #EAE8E1">

        <th rowspan="2" valign="middle" class="w-40 text-center text-sm">
            PARTICIPANTE
        </th>

        @foreach ($round_games as $game)
            <td class="text-left w-auto" >
                <img src="{{Storage::url($game->visit_team->logo)}}" class="avatar-xs">
                vs
                <img src="{{Storage::url($game->local_team->logo)}}" class="avatar-xs">
            </td>
        @endforeach
        <th rowspan="2" valign="middle" class="text-sm">ACIERTOS</th>
    </tr>
    <tr class="bg-dark text-white text-left text-sm">
        @foreach ($round_games as $game)
        <td>
            @if($game->visit_points || $game->local_pints)
                {{$game->visit_points ? $game->visit_points : '0' }}
                -
                {{ $game->local_points ? $game->local_points : '0' }}
            @endif
        </td>
    @endforeach
    </tr>
</thead>
