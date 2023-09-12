<div class="mt-2">
    @livewire('select-round')
    <div class="container-fluid mt-2">
        @if(isset($round_games) && !empty($round_games))
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table text-xs">
                                    @include('livewire.results.header_game_teams')

                                    <tbody>
                                        @foreach ($users_with_picks_round as $pick_user)
                                            <tr>
                                                @livewire('picks-round-user', ['user' => $pick_user,'round' => $selected_round], key($pick_user->id))
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

