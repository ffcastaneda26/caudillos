@php
    $allow_pick = $game->allow_pick();
    $is_last_game = $game->is_last_game_round();
    $pick_user = $game->pick_user();
    $print_score = $game->print_score();
    $acerto = $game->has_result() && $pick_user && $pick_user->winner == $game->winner;
    $game_date = strtotime($game->game_day);
    // $game_month = $meses[date('n', $game_date) - 1];
    $game_month = date('n', $game_date);
    $game_day = date('j', $game_date);
@endphp


<tr>
    <td class="text-left">{{ $game_day . '/' . $game_month }} {{ $game->game_time->format('H:i') }}</td>
    @include('livewire.picks.pick_visit')

    @if ($is_last_game)
        <td>
            <input type='number' wire:model="points_visit_last_game" min=0 max=99
                class="{{ $error == 'visit' || $error == 'tie' ? 'bg-red-500' : '' }}" {{ $allow_pick ? '' : 'disabled' }}>
        </td>
        {{-- Icono si acertó/falló o aún no se sabe --}}
        @include('livewire.picks.pick_icono_acerto')
        <td>
            <input type='number' wire:model="points_local_last_game" min=0 max=99
                class="{{ $error == 'local' || $error == 'tie' ? 'bg-red-500' : '' }}"
                {{ $allow_pick ? '' : 'disabled' }}>
        </td>
    @else
        @include('livewire.picks.pick_pick_result')
    @endif

    @include('livewire.picks.picks_local')


</tr>
