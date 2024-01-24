@if (env('ALLOW_SEARCH_PICKS_TABLE', true) && $view_search)
    <div class="card-header flex flex-col justify-start">
        <div class="row">
            <div class="ml-2">
                <div class="container mt-2 flex justify-items-center justify-start">
                    <label for="search-bar" class="mr-5">Participante</label>
                    <div class="search-bar" wire:ignore>
                        <input wire:model="search" class="search-input form-control" placeholder="{{ __($search_label) }}">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="d-none d-md-block ml-auto">
                <!-- Botones de radio para 'sort' -->
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-secondary">
                        <input wire:model="sort" type="radio" name="sort" value="name"> Nombre
                    </label>
                    <label class="btn btn-secondary">
                        <input wire:model="sort" type="radio" name="sort" value="picks"> Aciertos
                    </label>
                </div>

                <!-- Botones de radio para 'direction' -->
                <div class="btn-group btn-group-toggle ml-2" data-toggle="buttons">
                    <label class="btn btn-secondary">
                        <input wire:model="direction" type="radio" name="direction" value="asc"> Ascendente
                    </label>
                    <label class="btn btn-secondary">
                        <input wire:model="direction" type="radio" name="direction" value="desc"> Descendente
                    </label>
                </div>
            </div>

            <!-- Botones de radio para dispositivos móviles -->
            <div class="d-md-none mt-1">
                <div class="row">
                    <div class="ml-2">
                        <div class="container mt-2 flex justify-items-center justify-between">
                            <div class="col-md-6">
                                <div class="form-check">
                                    <input wire:model="sort" type="radio" name="sort_mobile" id="sort_name_mobile" class="form-check-input" value="name">
                                    <label class="form-check-label" for="sort_name_mobile">Nombre</label>
                                </div>
                                <div class="form-check">
                                    <input wire:model="sort" type="radio" name="sort_mobile" id="sort_picks_mobile" class="form-check-input" value="picks">
                                    <label class="form-check-label" for="sort_picks_mobile">Aciertos</label>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-check mt-2">
                                    <input wire:model="direction" type="radio" name="direction_mobile" id="direction_asc_mobile" class="form-check-input" value="asc">
                                    <label class="form-check-label" for="direction_asc_mobile">Ascendente</label>
                                </div>
                                <div class="form-check">
                                    <input wire:model="direction" type="radio" name="direction_mobile" id="direction_desc_mobile" class="form-check-input" value="desc">
                                    <label class="form-check-label" for="direction_desc_mobile">Descendente</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endif
