    {{-- Datos de la visita --}}
    <td><img src="{{Storage::url($game->visit_team->logo)}}" class="avatar-sm"></td>
    <td>{{ $game->visit_team->alias }}</td>

    <td align="center" valign="middle" class="{{ $game->winner == 2 ? 'font-bold bg-success rounded-full' : 'text-base font-mono'}}">{{ $game->visit_points }}</td>

