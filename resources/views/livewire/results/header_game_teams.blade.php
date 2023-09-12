<thead class="thead">
    <tr class="bg-dark text-white text-center text-sm">
        {{-- <th>Id</th> --}}
        <th rowspan="2" valign="middle" class="w-40">PARTICIPANTE</th>
        @foreach ($round_games as $game)
            <td class="text-left">
                <img src="{{Storage::url($game->visit_team->logo)}}" class="avatar-xs">
                <img src="{{Storage::url($game->local_team->logo)}}" class="avatar-xs">
            </td>
        @endforeach
        <th rowspan="2" valign="middle">ACIERTOS</th>
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
