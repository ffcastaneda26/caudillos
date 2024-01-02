<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <div class="flex items-center justify-center">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-gray-500">
                @if($isOpen && isset($view_form))
                    @include($view_form)
                @endif
            </div>
        </div>
    </div>
</div>

