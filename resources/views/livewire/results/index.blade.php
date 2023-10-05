<div>
    @livewire('select-round')
    <div class="container-fluid mt-2">
        @if(isset($round_games) && !empty($round_games))
            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="table text-xs">
                            @include('livewire.results.header_game_teams')
                            <tbody>
                                @foreach ($records as $pick_user)
                                    <tr>
                                        <td>{{ $pick_user->name }}</td>
                                        @foreach($selected_round->picks_user($pick_user->id)->get() as $pick)
                                            @livewire('user-pick-game', ['user'=> $pick->user_id,'game'=> $pick->game_id], key($pick->id))
                                        @endforeach
                                        <td class="text-base text-center">
                                            {{ $pick_user->has_position_record_round($selected_round->id) ? $pick_user->hits_round($selected_round->id) : ''}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @include('common.crud_pagination')
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

