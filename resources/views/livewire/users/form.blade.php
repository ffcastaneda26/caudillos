<div class="container">
    <div class="text-danger bg-white">
        <x-validation-errors></x-validation-errors>
    </div>

    @if($msg_error)
        <div class="text-danger">
            {{ $msg_error}}
        </div>
    @endif
    <div class="row align-items-start mt-2">
        {{-- Etiquetas de Campos --}}
        <div class="w-auto flex flex-col">
            <label class="input-group-text mb-2">Nombre</label>
            <label class="input-group-text mb-2">Apellido</label>

            <label class="input-group-text mb-2 mt-2">Correo</label>
            <label class="input-group-text mb-2 mt-2">Teléfono</label>
            <label class="input-group-text mb-2 mt-2">Rol</label>
            <label class="input-group-text mb-2">Contraseña</label>
            <label class="input-group-text mb-2">Confirmar</label>
            <label class="input-group-text mb-2 mt-2">¿Activo?</label>
        </div>

        <div class="col flex flex-col">
            {{-- Nombre --}}
            <div class="flex-flex-column mb-2">
                <input type="text"
                        wire:model="main_record.first_name"
                        required
                        placeholder="Nombre"
                        class="form-control @error('main_record.first_name') is-invalid @enderror"
                        maxlength="50"
                >
            </div>

            {{-- Apellido --}}
            <div class="flex-flex-column mb-2">
                <input type="text"
                        wire:model="main_record.last_name"
                        required
                        placeholder="Nombre"
                        class="form-control @error('main_record.last_name') is-invalid @enderror"
                        maxlength="50"
                >
            </div>
            {{-- Correo Electrónico --}}
             <div class="flex-flex-column mb-2">
                <input type="text"
                        wire:model="main_record.email"
                        required
                        placeholder="Correo Electrónico"
                        class="form-control @error('main_record.email') is-invalid @enderror"
                        maxlength="100"
                >
            </div>

            {{-- Teléfono --}}
             <div class="flex-flex-column mb-2">
                <input type="text"
                        wire:model="main_record.phone"
                        required
                        placeholder="Teléfono"
                        class="form-control mb-2 @error('main_record.phone') is-invalid @enderror"
                        maxlength="10"
                >
            </div>


            {{-- Rol --}}
            <div class="flex-flex-column mb-2">
                <select wire:model="role_id"
                        wire:change="read_role"
                        class="form-select form-select-md  rounded w-auto">
                    <option value="">Seleccione</option>
                    @foreach ($roles as $role_select)
                        <option value="{{ $role_select->id }}">
                            {{ $role_select->name}}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Contraseña --}}
             <div class="flex-flex-column mb-2">
                <input type="password" wire:model="password" maxlength="50" placeholder="Contraseña"
                    class="form-control">
            </div>


            {{-- Confrimar Contraseña --}}
            <div class="flex-flex-column">
                <input type="password" wire:model="password_confirmation" maxlength="50" placeholder="Confirmar"
                class="form-control">
            </div>

            {{-- ¿Activo? --}}


            <div class="flex-flex-column mt-2">
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
</div>
