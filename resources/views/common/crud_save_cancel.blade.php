<div class="d-flex justify-content-end">
    @if($allow_edit)
        <span class="mx-2">
            <button wire:click="closeModal()"
                class="btn btn-danger"
                wire:loading.remove>
                {{__("Cancel")}}
            </button>

        </span>
        <span class="mx-2">
            <button wire:click.prevent="store()"
                {{-- wire:loading.attr="hidden" --}}
                wire:loading.remove
                wire:loading.class="btn-secondary"
                class="btn btn-success">
                {{__("Save")}}
            </button>
            <div wire:loading wire:target="store">
                <p class="bg-white text-black font-bold text-2xl">Procesando...</p>
            </div>
        </span>
    @else
        <span class="mx-2">
            <button wire:click="closeModal()"
                class="btn btn-success">
                Regresar
            </button>
        </span>
    @endif

</div>
