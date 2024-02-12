<div>

    <td align="center">
        @if ($allow_pick)
            <x-reloj-image />
        @else
            @if ($pick_user->winner == 1)
                <img src="{{ Storage::url($pick_user->game->local_team->logo) }}" class="avatar-xs">
            @else
                <img src="{{ Storage::url($pick_user->game->visit_team->logo) }}" class="avatar-xs">
            @endif

            @if ($game_has_result)
                <span>
                    <img src="{{ $hit_game ? asset('images/afirmativo.png') : asset('images/negativo.png') }}"
                        height="10px" width="10px">
                </span>
            @endif
        @endif
    </td>

    @if ($is_tie_breaker_game)
        <td class="text-center {{ $tie_breaker_game_hit_game ? 'text-success' : 'text-danger' }}">
            @if ($tie_breaker_game_allow_pick)
                <x-reloj-image />
            @else
                <label class="{{ $tie_breaker_game_hit_game ? '' : 'text-red' }}">
                    {{ $visit_points . '-' . $local_points }}
                </label>
                @if ($pick_user->winner == 1)
                    <img src="{{ Storage::url($pick_user->game->local_team->logo) }}" class="avatar-xs">
                @else
                    <img src="{{ Storage::url($pick_user->game->visit_team->logo) }}" class="avatar-xs">
                @endif

                <span>
                    <img src="{{ $tie_breaker_game_hit_game ? asset('images/afirmativo.png') : asset('images/negativo.png') }}"
                        height="10px" width="10px">
                </span>
            @endif
        </td>

        <td class="text-center">
            {{ $user_has_position_in_round ? $user_round_position : 'X' }}
        </td>

    @endif

</div>
