<tr>
    <td>{{ $position->position }}</td>
    <td>{{ $position->user->name }}</td>
    <td align="center">{{ $position->hits }}</td>


    <td align="center">
        @if($position->dif_victory)
            <img src="{{ $position->hit_last_game  ? asset('images/afirmativo.png') : asset('images/negativo.png') }}"
            width="17" height="17">

        @else
            <img src="{{ asset('images/reloj.jpg') }}" alt="" width="17" height="17">
        @endif

    </td>

    <td align="center">{{ $position->dif_total_points }}</td>
    <td align="center">{{ $position->best_shot }}</td>
    <td align="center">{{ $position->dif_winner_points }}</td>
    <td align="center">{{ $position->dif_victory }}</td>
</tr>

