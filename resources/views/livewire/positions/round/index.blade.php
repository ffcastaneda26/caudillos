<div>
    @livewire('select-round')
    <div class="container-fluid">
        @if(isset($records ))
            <div class="mt-3 flex justify-center">
                <div class="{{ $tie_breaker_game_played ? 'col-sm-8' : 'col-4'}}">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover text-xs">
                                    @include('livewire.positions.round.table')
                                    <tbody>
                                        @foreach ($records as $position)
                                            @include('livewire.positions.round.list')
                                        @endforeach
                                    </tbody>
                                </table>
                                <div>
                                    {{ $records->links()}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
