<div class="container">
    {{-- <x-jet-validation-errors></x-jet-validation-errors> --}}
    <x-validation-errors></x-validation-errors>
    <div class="row align-items-start">
        <div class="col-md-4 flex flex-col mt-2">
            <label class="input-group-text mb-2">F. Inicio</label>
            <label class="input-group-text mb-2">F. Final</label>
            <label class="input-group-text mb-3">Tipo</label>
            <label class="input-group-text mb-4">Activa</label>
        </div>

        <div class="col flex flex-col mt-2">
            {{-- Fecha Inicio --}}
            <div class="flex flex-col mb-2">
                <input wire:model="main_record.start_date"
                        type="date"
                        class="p-2  border rounded-md w-30"
                        required
                >
            </div>

            {{-- Fecha Final --}}
            <div class="flex flex-col mb-2">
                <input wire:model="main_record.end_date"
                        type="date"
                        class="p-2  border rounded-md w-30"
                        required
                >
            </div>

            {{-- Tipo --}}
            <div class="flex flex-col mb-2">
                <select wire:model="main_record.type"
                        class="form-select rounded w-1/2" >
                        <option value="">Tipo</option>
                        <option value="Regular"{{ $main_record->type == 'Regular' ? 'selected' : '' }}>Regular</option>
                        <option value="Divisional"{{ $main_record->type == 'Divisional' ? 'selected' : '' }}>Divisional</option>
                        <option value="Conferencia"{{ $main_record->type == 'Conferencia' ? 'selected' : '' }}>Conferencia</option>
                </select>
            </div>
            {{-- ¿Activa? --}}
                <div class="flex flex-col-2 bg-white justify-around">
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" wire:model="main_record.active" class="btn-check" name="type" id="active" value="1">
                        <label class="btn btn-outline-success" for="active">{{__('Active')}}</label>
                        <input type="radio" wire:model="main_record.active" class="btn-check" name="type" id="inactive" value="0">
                        <label class="btn btn-outline-danger" for="inactive">{{__('Inactive')}}</label>
                    </div>
                </div>

        </div>


    </div>
</div>
