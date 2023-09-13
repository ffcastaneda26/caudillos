<div class="container">
    <x-validation-errors></x-validation-errors>
    <div class="text-danger text-2xl bg-white">
        {{ $error_message }}
    </div>


    <div class="row align-items-start mt-2">
        <div class="col-md-3 flex flex-col">
            <label class="input-group-text mb-2">{{__("Jornada")}}</label>

            <label class="input-group-text mb-2">{{__("Fecha")}}</label>
            <label class="input-group-text mb-2">{{__("Hora")}}</label>
            <label class="input-group-text mb-2">{{__("Visita")}}</label>
            <label class="input-group-text mb-2">{{__("Pts Visita")}}</label>
            <label class="input-group-text mb-2">{{__("Local")}}</label>
            <label class="input-group-text mb-2">{{__("Pts Local")}}</label>
        </div>

        {{-- Controles para los datos --}}
        <div class="col flex flex-col">
            {{-- Jornada --}}
            <select wire:model="main_record.round_id"
                      class="form-select rounded w-auto mb-2">
                    <option value="">Local</option>
                    @foreach($rounds as $round)
                            <option value="{{ $round->id }}">
                                {{ $round->id .' Del ' .$round->start_date->format('j-M-y') .' al ' . $round->end_date->format('j-M-y') }}
                            </option>
                    @endforeach
            </select>

            {{-- Fecha --}}
            <input wire:model="main_record.game_day"
                        type="date"
                        class="p-2  border rounded-md w-30"
                        required
                >

            {{-- Hora --}}
            <input type="time"
                    wire:model="main_record.game_time"
                    class="form-control  mb-2"
            >

            {{-- Visita --}}
            <select wire:model="main_record.visit_team_id"
                    class="form-select rounded w-auto mb-2">
                    <option value="">Visita</option>
                    @foreach($teams as $visit_team)
                            <option value="{{ $visit_team->id }}">
                                {{ $visit_team->alias }}
                            </option>
                    @endforeach
            </select>

            {{-- Puntos Visita --}}
            <input type="number"
                    wire:model="main_record.visit_points"
                    class="form-control mb-2 @error('main_record.visit_points') is-invalid @enderror"
                    @if($error == 'visit')
                        <div class="badge rounded-pill bg-danger">{{ $error_message }}</div>
                    @endif
               >
            {{-- Local --}}
            <select wire:model="main_record.local_team_id"
                    class="form-select rounded w-auto mb-2">
                    <option value="">Local</option>
                    @foreach($teams as $local_team)
                            <option value="{{ $local_team->id }}">
                                {{ $local_team->alias }}
                            </option>
                    @endforeach
                    @if($error == 'local')
                        <div class="badge rounded-pill bg-danger">{{ $error_message }}</div>
                    @endif
            </select>

            {{-- Puntos Local --}}
            <input type="number"
                    wire:model="main_record.local_points"
                    class="form-control mb-2 @error('main_record.local_points') is-invalid @enderror"
            >

        </div>
    </div>
</div>
