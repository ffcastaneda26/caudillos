<tr>
    {{-- @dd($position) --}}
    <td>{{ $position->position }}</td>
    <td>{{ $position->name }}</td>
    <td align="center">{{ $position->hits }}</td>

    @if($tie_breaker_game_played)
        <td align="center">

                <img src="{{ $position->hit_last_game  ? asset('images/afirmativo.png')
                                                       : asset('images/negativo.png') }}"
                width="17" height="17">
        </td>
        <td align="center">{{ $position->dif_total_points }}</td>
        <td align="center">{{ $position->best_shot }}</td>
        <td align="center">{{ $position->dif_winner_points }}</td>
        <td align="center">{{ $position->dif_victory }}</td>
    @else
        <td colspan="2">NO DESEMPATE</td>
    @endif
</tr>
