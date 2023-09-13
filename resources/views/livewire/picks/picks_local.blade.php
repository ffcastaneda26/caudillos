   {{-- Datos del Local --}}
   <td align="center" valign="middle" class="{{ $game->winner == 1 ? 'font-bold  bg-success rounded-full' : 'text-base font-mono'}}">{{ $game->local_points }}</td>
   <td>{{ $game->local_team->alias }}</td>
   <td><img src="{{Storage::url($game->local_team->logo)}}" class="avatar-sm"></td>
