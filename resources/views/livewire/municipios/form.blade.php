<div class="container">
    <x-validation-errors></x-validation-errors>
    <div class="row align-items-start">
        <div class="col-md-4 flex flex-col">
            <label class="input-group-text mb-2">{{__("Entidad")}}</label>
            <label class="input-group-text mb-2">{{__("Municipio")}}</label>
            <label class="input-group-text mb-2">{{__("Predeteraminado")}}</label>

        </div>

        <div class="col flex flex-col">
            {{-- Entidad --}}
            <div class="flex-flex-column">
                <select wire:model="main_record.entidad_id"
                        class="form-select form-select-md  rounded w-auto mb-2"
                        {{ $record_id ? 'disabled' : ''}}
                >
                        <option value="">Seleccione</option>
                        @foreach($entidades as $entidad)
                                <option value="{{ $entidad->id }}">
                                    {{ $entidad->nombre }}
                                </option>
                        @endforeach
                  </select>

            </div>


            {{-- Municipio --}}
            @include('livewire.commons.main_record_input_nombre_field')

            @include('livewire.commons.input_predeterminado_field')



        </div>
    </div>
</div>
