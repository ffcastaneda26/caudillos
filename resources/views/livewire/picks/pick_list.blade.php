@php
    $allow_pick = $game->allow_pick();
    $is_last_game = $game->is_last_game_round();
    $is_game_tie_breaker = $game->is_game_tie_breaker();
    $is_last_game_round_to_pick = $game->is_last_game_round_to_pick();
    $pick_user = $game->pick_user();
    $print_score = $game->print_score();
    $acerto = $game->has_result() && $pick_user && $pick_user->winner == $game->winner;
    $game_date = strtotime($game->game_day);
    $game_month = date('n', $game_date);
    $game_day = date('j', $game_date);
@endphp

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
