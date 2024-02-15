<td align="center"  class="text-center {{ $tie_breaker_game_hit_by_user ? 'text-success' : 'text-danger' }}">

    @if ($tie_breaker_game_allow_pick)
        <x-reloj-image />
    @else
         @if($tie_breaker_game_has_result)
            <label class="{{ $tie_breaker_game_hit_by_user ? '' : 'text-danger' }}">
                {{ $tie_breaker_game_pick_user->visit_points . '-' . $tie_breaker_game_pick_user->local_points }}
             </label>
        @else
            <label class="text-muted">
                {{ $tie_breaker_game_pick_user->visit_points . '-' . $tie_breaker_game_pick_user->local_points }}
            </label>
        @endif

        @if ($tie_breaker_game_pick_user->winner == 1)
            <img src="{{ Storage::url($tie_breaker_game_pick_user->game->local_team->logo) }}" class="avatar-xs">
        @else
            <img src="{{ Storage::url($tie_breaker_game_pick_user->game->visit_team->logo) }}" class="avatar-xs">
        @endif
        @if($tie_breaker_game_has_result)
            <span>
                @include('livewire.results.list_hit_game_icon')
            </span>
        @endif

    @endif
</td>
