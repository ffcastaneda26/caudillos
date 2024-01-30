<div>
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover text-xs">

                        <tbody>
                            <tr>
                                <td>{{ $game->id }}</td>
                                <td align="left" class="text-center text-xs">
                                    {{ $game_day . '/' . $game_month }} {{ $game->game_time->format('H:i') }}
                                </td>

                                @include('livewire.picksgames.pick_visit')

                                @if ($id_game_tie_breaker === $game->id)
                                    @include('livewire.picksgames.pick_list_tie_breaker_game')
                                @else
                                    @include('livewire.picksgames.pick_radio_buttons')
                                @endif

                                @include('livewire.picksgames.pick_local')
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
