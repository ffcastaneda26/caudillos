{{-- Equipo Visita --}}
<div class="col flex justify-center">
    <div class="flex flex-col justify-center">
        <div style="width: 30px">
            <img src="{{ Storage::url($game->visit_team->logo) }}"
                class="avatar-sm md:w-100 h-100">
        </div>
        <div style="width: 30px">
            <label class="rounded-pill text-xs p-1
                    {{ !is_null($game->visit_points) ? '' : 'd-none' }}
                    {{ $game->winner == 2 ? 'game_winner' : 'game_loser' }}">
                {{ $game->visit_points }}
            </label>
        </div>
    </div>
</div>

