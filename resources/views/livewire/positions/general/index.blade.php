<div>

    <div class="container-fluid mt-2">
        @if (isset($records))
            <div class="flex flex-row justify-center">
                <div class="card">
                    @include('livewire.positions.general.search')
                </div>
            </div>
            <div class="mt-3 flex justify-center">
                <div class="col-sm-8">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover text-xs">
                            @include('livewire.positions.general.table')
                            <tbody>
                                @foreach ($records as $position)
                                    @include('livewire.positions.general.list')
                                @endforeach
                            </tbody>
                        </table>
                        <div>
                            {{ $records->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
