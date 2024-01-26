<tr>

    <td>{{ $position->position }}</td>
    <td>{{ $position->name }}</td>
    <td align="center">{{ $position->hits ?  $position->hits : '-'}}</td>

    @if ($tie_breaker_game_played)
        <td align="center">
            <img src="{{ $position->hit_last_game ? asset('images/afirmativo.png') : asset('images/negativo.png') }}"
                width="17" height="17">
        </td>
        <td align="center">{{ $position->dif_total_points }}</td>
        <td align="center">{{ $position->best_shot }}</td>
        <td align="center">{{ $position->dif_winner_points }}</td>
        <td align="center">{{ $position->dif_victory }}</td>
    @else
        @if ($position->tie_break_winner)
            <td>
                @if ($position->tie_break_winner == 1)
                    <img src="{{ Storage::url($tie_breaker_game->local_team->logo) }}" class="avatar-xs md:w-100 h-100">
                @else
                    <img src="{{ Storage::url($tie_breaker_game->visit_team->logo) }}" class="avatar-xs md:w-100 h-100">
                @endif
            </td>
            <td>{{ $position->tie_break_visit_points . '-' . $position->tie_break_local_points }}</td>
        @else
            <td style="text-align: center;">
                <x-reloj-image />
            </th>
        @endif
    @endif
</tr>
