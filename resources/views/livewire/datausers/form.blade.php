<div class="container">

    {{-- <x-validation-errors></x-validation-errors> --}}


    <div class="row align-items-start">


        <div class="col flex flex-col mt-2">
            {{-- Entidad --}}
            <div class="flex-flex-column mb-2">
                <select wire:model="main_record.entidad_id"
                        wire:change="lee_entidad"
                        {{ $this->allow_edit ? '' : 'disabled'}}
                        class="form-select form-select-md  sm:mr-2 {{ $errors->has('entidad_id') ? 'bg-red-500' : '' }}"
                        {{ Auth::user()->has_suplementary_data() ? 'disabled' : ''}}>
                    <option value="" selected>Seleccionar Entidad</option>
                    @foreach($entidades as $entidad_select)
                        <option value="{{ $entidad_select->id }}">{{ $entidad_select->nombre }}</option>
                    @endforeach
                </select>
                @error('main_record.entidad_id')<div class="badge rounded-pill bg-danger">{{ $message }}</div>@enderror
            </div>

            {{-- Municipio --}}
            <div class="flex-flex-column">
                <select wire:model="main_record.municipio_id"
                        {{ $this->allow_edit ? '' : 'disabled'}}
                        class="form-select form-select-md sm:mr-2
                            {{ $main_record->entidad_id ? '' : 'hidden' }}
                                 {{ $errors->has('entidad_id') ? 'bg-red-500' : '' }}"
                        {{ Auth::user()->has_suplementary_data() ? 'disabled' : ''}}
                        {{ !isset($municipios) ? 'disabled' : ''}}>

                    <option value="" selected>Seleccionar Municipio</option>

                    @if(isset($municipios) && $municipios->count())
                        @foreach($entidad->municipios as $municipio)
                            <option value="{{ $municipio->id }}">{{ $municipio->nombre }}</option>
                        @endforeach
                    @endif
                </select>
                @error('main_record.municipio_id')<div class="badge rounded-pill bg-danger"></div>@enderror

            </div>

            {{-- Código Postal --}}
            <div class="flex-flex-column mb-2">
                <input type="text"
                    wire:model="main_record.codpos"
                    placeholder="Código Postal"
                    {{ $this->allow_edit ? '' : 'disabled'}}
                    class="block mt-1 rounded  {{ $errors->has('codpos') ? 'bg-red-500' : '' }}"
                    {{ $this->allow_edit ? '' : 'disabled'}}
                    @if (!$this->allow_edit)
                        style="background-color:#e9ecef;"
                    @endif
                    size="10"
                    minlength="5"
                    maxlength="5"
                >
                @error('main_record.codpos')<div class="badge rounded-pill bg-danger">{{ $message }}</div>@enderror
            </div>

            {{--Género --}}
            <div class="flex-flex-column mb-2">
                <select wire:model="main_record.gender"
                        {{ $this->allow_edit ? '' : 'disabled'}}
                        class="form-select form-select-md sm:mr-2 w-80 {{ $errors->has('gender') ? 'bg-red-500' : '' }}">
                    <option value="" selected>Seleccionar Género</option>
                    <option value="Hombre" class="bg-blue-500">Hombre</option>
                    <option value="Mujer" class="bg-pink-500">Mujer</option>
                </select>
                @error('main_record.gender')<div class="badge rounded-pill bg-danger">{{ $message }}</div>@enderror
            </div>

            {{-- Fecha de Nacimiento --}}
            <div class="flex-flex-column mb-2">
                <label for="" class="text-white">Fecha de Nacimiento</label>
                    <input wire:model="main_record.birthday"
                            type="date"
                            placeholder="F. Nacimiento"
                            {{ $this->allow_edit ? '' : 'disabled'}}
                            @if (!$this->allow_edit)
                                style="background-color:#e9ecef;"
                            @endif
                            max="{{Carbon\Carbon::now()->subYear(18)->format('Y-m-d')}}"
                            class="p-2  border rounded-md w-40 {{ $errors->has('birthday') ? 'bg-red-500' : '' }}"
                            required
                    >
                @error('main_record.birthday')<div class="badge rounded-pill bg-danger">{{ $message }}</div>@enderror
            </div>

            {{-- CURP --}}
            <div class="flex-flex-column mb-2">
                <input  wire:model.debounce.150ms="main_record.curp"
                        type="text"

                        {{ $this->allow_edit ? '' : 'disabled'}}
                        @if (!$this->allow_edit)
                            style="background-color:#e9ecef;"
                        @endif
                        class="p-2 border rounded-md {{ $errors->has('curp') ? 'bg-red-500' : '' }}"
                        required
                        size="21"
                        maxlength="18"
                        minlength="18"
                        placeholder="CURP"
                        pattern="^[A-Z][A,E,I,O,U,X][A-Z]{2}[0-9]{2}[0-1][0-9][0-3][0-9][M,H][A-Z]{2}[B,C,D,F,G,H,J,K,L,M,N,Ñ,P,Q,R,S,T,V,W,X,Y,Z]{3}[0-9,A-Z][0-9]$"
                >
                @error('main_record.curp')<div class="badge rounded-pill bg-danger">{{ $message }}</div>@enderror
                @if ($error_message)
                    <div class="badge rounded-pill bg-danger">
                               {{ $error_message }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Etiquetas para Credencial INE --}}
    <div class="row align-items-start">
        <div class="row align-items-start justify-between">
            <div class="w-1/2 flex flex-col mt-2">
                <label class="input-group-text mb-2">INE Frontal</label>
                @error('ine_anverso')<div class="badge rounded-pill bg-danger">{{ $message }}</div>@enderror
            </div>

            <div class="w-1/2 flex flex-col mt-2">
                <label class="input-group-text mb-2 text-center">INE Reverso</label>
                @error('ine_reverso')<div class="badge rounded-pill bg-danger">{{ $message }}</div>@enderror

            </div>
        </div>
    </div>

    @if($this->allow_edit)
        {{-- Seleccionar Archivos de INE --}}
        <div class="row align-items-start">
            <div class="row align-items-start justify-between">
                <div class="w-1/2 flex flex-col mt-2">
                    <div class="col-lg-6  col-md-8 mb-4 {{ $errors->has('curp') ? 'bg-red-500' : '' }}">
                        <input type="file"
                                wire:model="ine_anverso"
                                {{$allow_edit ? '' : 'disabled' }}
                                class="form-control">
                    </div>
                </div>

                <div class="w-1/2 flex flex-col mt-2">
                    <div class="col-lg-6  col-md-8 mb-4">
                        <input type="file"
                                wire:model="ine_reverso"
                                {{$allow_edit ? '' : 'disabled' }}
                                class="form-control">
                    </div>
                </div>
            </div>
        </div>

        {{-- Imagen Temporal --}}
        <div class="row align-items-start">
            <div class="row align-items-start justify-between">
                <div class="w-1/2 flex flex-col mt-2">
                    @if (isset($ine_anverso))
                        @if(in_array($this->ine_anverso->getClientOriginalExtension(),$extensions_file))
                            <img src="{{ $ine_anverso->temporaryUrl() }}" class="avatar-md">
                        @else
                            <div class="flex items-center">
                                    <label for="" class="underline text-sm text-red-600 dark:text-gray-400 hover:text-red-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
                                        Formato no permitido: Debe ser imagen
                                    </label>
                            </div>
                        @endif
                    @endif

                </div>

                <div class="w-1/2 flex flex-col mt-2">
                    <div class="col-lg-6  col-md-8 mb-4">
                        @if (isset($ine_reverso))
                            @if(in_array($this->ine_reverso->getClientOriginalExtension(),$extensions_file))
                                <img src="{{ $ine_reverso->temporaryUrl() }}" class="avatar-md">
                            @else
                                <div class="flex items-center">
                                        <label for="" class="underline text-sm text-red-600 dark:text-gray-400 hover:text-red-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
                                            Formato no permitido: Debe ser imagen
                                        </label>
                                </div>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>

        {{-- Aceptar que se grabaran --}}
        <div class="row align-items-start">
            <div class="mt-4">
                <x-label for="confirmar">
                    <div class="flex items-center">
                        <x-checkbox wire:model="confirmar" required />
                        <div class="ml-2">
                            <label for="" class="underline text-sm text-white dark:text-gray-400 hover:text-red-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 dark:focus:ring-offset-gray-800">
                                Acepto que al enviar mis datos no podrán ser modificados
                            </label>
                        </div>
                    </div>
                </x-label>
                @error('confirmar')<span class="badge rounded-pill bg-danger">{{ $message }}</span>@enderror
            </div>
        </div>
@else
        {{-- Imagenes Grabadas --}}
        <div class="row align-items-start">
            <div class="row align-items-start justify-between">
                <div class="w-1/2 flex flex-col mt-2 justify-center">
                      @if (isset($main_record->ine_anverso))
                        <img src="{{Storage::url($main_record->ine_anverso)}}" class="avatar-sm" alt="">
                    @endif
                </div>

                <div class="w-1/2 flex flex-col mt-2 justify-center">
                    <div class="col-lg-6  col-md-8 mb-4">
                        @if (isset($main_record->ine_reverso))
                            <img src="{{Storage::url($main_record->ine_reverso)}}" class="avatar-sm" alt="">
                        @endif
                    </div>
                </div>
            </div>
        </div>
@endif



    {{-- Botones de acción --}}
    <div class="modal-footer">
        <div class="d-flex justify-content-around">
            @if(!$this->allow_edit)
                <div class="w-1/2">
                    <p class="text-white">Si necesita actualizar los datos póngase en contacto con un administrador</p>
                </div>
            @endif
            <button wire:click="closeDataUser()"
                class="btn btn-danger">
                {{__("Cancel")}}
            </button>

            @if(isset($confirmar) && $confirmar  && isset($ine_anverso) && isset($ine_reverso) && $main_record->entidad_id  && $main_record->municipio_id && $main_record->codpos && $main_record->gender && $main_record->birthday && $main_record->curp)
                @if($this->allow_edit)
                    <button  onclick="confirm_user_data()"
                        class="btn btn-success"
                        title="Guardar"
                        {{ isset($ine_anverso) && isset($ine_reverso) ? '' : 'disabled'}}>
                        {{__("Save")}}
                        <i class="mdi mdi-content-save-alert"></i>
                    </button>
                @endif
            @endif
        </div>
    </div>
</div>
