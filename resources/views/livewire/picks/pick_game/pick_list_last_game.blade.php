{{-- Puntos Visita --}}
<td align="center">
    <input type='number'
            wire:model="visit_points"
            wire:change="update_points"
            wire:blur="update_points"
            min=0 max=999 style="font-size: 8px"
            class="w-auto {{ $errors->has('visit_points') ? 'border border-danger border-3' : '' }}" {{ $allow_pick ? '' : 'disabled' }}>
    @error('visit_points')
        <span class="invalid-feedback text-xs" role="alert">
            <strong>{{ $message }}</strong>
            <span class="badge badge-danger">Error</span>
        </span>
    @enderror
</td>
{{-- Icono si acertó/falló o aún no se sabe --}}
@if ($game_has_result)
    @include('livewire.picks.pick_icono_acerto')
@endif

{{-- Puntos Local --}}
<td align="center">
    <input type='number'
            wire:model="local_points"
            wire:change="update_points"
            wire:blur="update_points"
            min=0 max=127 style="font-size: 8px"
            class="w-auto {{ $errors->has('local_points') ? 'border border-danger border-3' : '' }}" {{ $allow_pick ? '' : 'disabled' }}>

    @error('local_points')
        <span class="invalid-feedback text-xs" role="alert">
            <strong>{{ $message }}</strong>
            <span class="badge badge-danger">{{ $message }}</span>
        </span>
    @enderror
</td>
