{{-- Datos del Local --}}
<div class="col flex justify-center">
    <div class="flex flex-col justify-center">
        <div style="width: 30px">
            <img src="{{ Storage::url($game->local_team->logo) }}" class="avatar-sm md:w-100 h-100">
        </div>
        <div style="width: 30px">
            <label  class="rounded-pill  text-md p-1.5
                    {{ !is_null($game->local_points) ? '' : 'd-none' }}
                    {{ $game->winner == 1 ? 'bg-success' : 'bg-danger' }}">
                    {{ $game->local_points }}
            </label>
        </div>
    </div>
</div>
