    {{-- Datos de la visita --}}
    <td><img src="{{Storage::url($game->visit_team->logo)}}" class="avatar-sm"></td>
    <td>{{ $game->visit_team->alias }}</td>

    {{-- <td align="center" style="vertical-align:top;"><label class="{{ $game->winner == 2 ? 'rounded-pill bg-success text-lg' : 'text-base font-mono'}}">{{ $game->visit_points }}</label></td> --}}

    <td align="center" style="vertical-align:top;">
        <label class="rounded-pill  text-lg p-1.5 {{ $game->winner == 2 ? 'bg-success' : 'bg-danger'}}">
            {{ $game->visit_points }}
        </label>
    </td>
