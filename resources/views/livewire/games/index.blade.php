<div>
    @livewire('select-round')
    <div class="container-fluid mt-2">
        @include('common.crud_header')
        @include('common.crud_message')
        <div class="d-flex flex-row align-items-start col-md-12 gap-2 mb-2">
            <div class="d-flex flex-row align-items-start col-md-8 gap-2 mb-2">
                {{--  Boton para crear Registro  --}}
                @if ($allow_create)
                    @include('common.crud_create_button')
                @endif
                {{--  Vista busquedas de items  --}}
                @if (isset($view_search))
                    @include($view_search)
                @endif
            </div>
        </div>


        {{-- Detalle de registros de la jornada --}}
        <div class="flex  justify-center justify-items-center">

            <div class="table-responsive bg-white">
                @if (isset($round_games) && $round_games->count())
                    <table class="table table-striped table-hover mb-0">
                        @if (isset($view_table))
                            @include($view_table)
                        @endif
                        <tbody>
                            @foreach ($round_games as $game)
                                @include($view_list)
                            @endforeach
                        </tbody>
                    </table>
                @else
                    @include('common.no_records_found')
                @endif
            </div>
        </div>



        {{-- Formulario Crear o Editar --}}
        @if ($isOpen && isset($view_form))
            @include('common.crud_modal_form')
        @endif
    </div>
</div>
