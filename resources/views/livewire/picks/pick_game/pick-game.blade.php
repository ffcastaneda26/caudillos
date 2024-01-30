<div>
    <div class="table-responsive">
        <table class="table table-striped table-hover text-xs">
            <tbody>
                <tr>
                    <td>{{ $game->id }}</td>
                    <td align="left" class="text-center text-xs">
                        {{ $game_day . '/' . $game_month }} {{ $game->game_time->format('H:i') }}
                    </td>
                    {{-- @include('livewire.picks.pick_visit') --}}
                    @include('livewire.picks.pick_game.pick_visit')


                    @if ($id_game_tie_breaker == $game->id)
                        @include('livewire.picks.pick_game.pick_list_tie_breaker_game')
                    @else
                        @include('livewire.picks.pick_game.pick_pick_result')
                    @endif

                    {{-- @include('livewire.picks.picks_local') --}}
                    @include('livewire.picks.pick_game.pick_local')


                </tr>
            </tbody>
        </table>
    </div>
</div>
