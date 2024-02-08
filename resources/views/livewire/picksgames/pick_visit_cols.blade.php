{{-- Equipo Visita --}}
<div class="col flex justify-center">
    <div class="flex flex-col justify-center">
        <div style="width: 30px">
            <img src="{{ Storage::url($game->visit_team->logo) }}"
                class="avatar-sm md:w-100 h-100">
        </div>
        <div style="width: 30px">
            <label class="rounded-pill  text-lg p-1.5
                    {{ !is_null($game->visit_points) ? '' : 'd-none' }}
                    {{ $game->winner == 2 ? 'bg-success' : 'bg-danger' }}">
                {{ $game->visit_points }}
            </label>
        </div>
    </div>
</div>

