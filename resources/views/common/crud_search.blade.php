    <!-- Search input -->
<div class="container mt-2 flex justify-items-center justify-center">
    <div class="search-bar">
        <input class="search-input form-control"
                wire:model="search"
                id="search_data"
                name="search_data"
                placeholder="{{__($search_label)}}"
        >
    </div>
</div>
