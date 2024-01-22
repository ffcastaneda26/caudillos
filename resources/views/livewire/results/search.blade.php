@if (env('ALLOW_SEARCH_PICKS_TABLE', true) && $view_search)
    <div class="card-header flex flex-row justify-start">
        <label for="search-bar" class="mr-5">Participante</label>
        <div class="ml-2">
            <div class="container mt-2 flex justify-items-center justify-between">
                <div wire:ignore>

                </div>

                <div class="search-bar" wire:ignore>
                    <input wire:model="search" class="search-input form-control"
                        placeholder="{{ __($search_label) }}">
                </div>
            </div>

        </div>
    </div>
@endif
