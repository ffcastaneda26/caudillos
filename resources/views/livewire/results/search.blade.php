@if (env('ALLOW_SEARCH_PICKS_TABLE', true) && $view_search)
    <div class="card-header flex flex-col justify-start">
        <div class="row flex flex-row justify-around">
            <div class="col-6">
                <div class="p-2">
                        <label for="search-bar" class="mr-5">Participante</label>
                        <div class="search-bar" wire:ignore>
                            <input wire:model="search" class="search-input form-control" placeholder="{{ __($search_label) }}">
                        </div>
                </div>
            </div>
            <div class="col-6">
                <div class="p-2">
                        <label class="text-center mx-auto">Ordenar Por</label>
                        <select wire:model="order_by" class="form-control text-sm">
                            <option value="name_asc">Participante A-Z</option>
                            <option value="name_desc">Participante Z-A</option>
                            <option value="picks_asc">Aciertos A-Z</option>
                            <option value="picks_desc">Aciertos Z-A</option>
                        </select>
                </div>
            </div>

        </div>
    </div>
@endif
