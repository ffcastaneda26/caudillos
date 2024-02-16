@if (env('ALLOW_SEARCH_PICKS_TABLE', true) && $view_search)
    <div class="card-header flex flex-col justify-start">
        <div class="row flex flex-row justify-around">
            <div class="col-6">
                <div class="p-2">
                        <label for="search-bar" class="mr-5">Participante</label>
                        <div class="search-bar" wire:ignore>
                            <input wire:model="search"
                                    class="search-input form-control"
                                    placeholder="{{ __($search_label) }}"
                                    id="search_data"
                                    name="search_data">
                        </div>
                </div>
            </div>
            <div class="col-6">
                <div class="p-2">
                        <label for="" class="text-center mx-auto">Ordenar Por</label>
                        <select wire:model="order_by" class="form-control text-sm" id="order_by" name="order_by">
                            <option value="name_asc">Participante ↓</option>
                            <option value="name_desc">Participante ↑</option>
                            <option value="hits_asc">Puntos ↓</option>
                            <option value="hits_desc">Puntos ↑</option>
                        </select>
                </div>
            </div>

        </div>
    </div>
@endif
