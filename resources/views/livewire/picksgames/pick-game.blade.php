<div  wire:poll>
    <table class="table table-responsive table-striped table-hover text-xs">
        <tr>
            <td>{{ $game->id }}</td>
            <td align="left" class="text-center text-xs">
                {{ $game_day . '/' . $game_month }} {{ $game->game_time->format('H:i') }}
            </td>

            @include('livewire.picksgames.pick_visit')

            @if($configuration->require_points_in_picks)
                @include('livewire.picksgames.pick_list_tie_breaker_game')
            @else
                @if ($is_game_tie_breaker)
                    @include('livewire.picksgames.pick_list_tie_breaker_game')
                @else
                    @include('livewire.picksgames.pick_radio_buttons')
                @endif
            @endif

            @include('livewire.picksgames.pick_local')
        </tr>
    </table>
</div>
