<div>
    <tr>
        <td>{{ $game->id }}</td>
        <td align="center" class="text-center text-xs">
            {{ $game_day . '/' . $game_month }} {{ $game->game_time->format('H:i') }}
        </td>
        @include('livewire.picks.pick_visit')

        @if($id_game_last_game_round == $game->id)
            @include('livewire.picks.pick_list_last_game')
        @else
            @include('livewire.picks.pick_pick_result')
        @endif

        @include('livewire.picks.picks_local')


    </tr>

</div>
