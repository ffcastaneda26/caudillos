<div>
    @livewire('select-round')

    <div class="container-fluid mt-2">
        @if (isset($round_games) && !empty($round_games))
            <div class="flex flex-row justify-center">
                <div class="card">
                    {{-- Buscar --}}

                    @include('livewire.results.search')

                    <div class="card-body ">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table text-xs">
                                    @include('livewire.results.header_game_teams')
                                    <tbody>
                                        @foreach ($users as $user)
                                            @include('livewire.results.list')
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($users && $users->count())
                                    <div>
                                        {{ $users->links()}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
