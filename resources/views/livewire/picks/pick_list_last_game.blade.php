<td align="center">
    {{-- <input type='number' wire:model="points_visit_last_game" min=0 max=127 style="font-size: 8px"
        class="w-auto {{ $error == 'visit' || $error == 'tie' ? 'bg-red-500' : '' }}"
        {{ $allow_pick ? '' : 'disabled' }}> --}}
    <input type='number'
            wire:model="visit_points"
            wire:change="update_points"
            wire:blur="update_points"
            min=0 max=127 style="font-size: 8px"
            class="w-auto {{ $errors->has('visit_points') ? ' is-invalid' : '' }}" {{ $allow_pick ? '' : 'disabled' }}>
        @error('visit_points')
            <span class="invalid-feedback text-xs" role="alert">
                <strong>{{ $message }}</strong>
                <span class="badge badge-danger">Error</span>
            </span>
        @enderror
</td>
{{-- Icono si acertó/falló o aún no se sabe --}}
@if ($game->has_result())
    @include('livewire.picks.pick_icono_acerto')
@endif
<td align="center">
    {{-- <input type='number' wire:model="points_local_last_game" min=0 max=127 style="font-size: 8px"
    class="w-auto text-center  {{ $error == 'local' || $error == 'tie' ? 'bg-red-500' : '' }}"
    {{ $allow_pick ? '' : 'disabled' }}> --}}
    <input type='number'
            wire:model="local_points"
            wire:change="update_points"
            wire:blur="update_points"
            min=0
            max=127
            style="font-size: 8px"
            class="w-auto {{ $errors->has('local_points') ? ' is-invalid' : '' }}" {{ $allow_pick ? '' : 'disabled' }}>
    @error('local_points')
        <span class="invalid-feedback text-xs" role="alert">
            <strong>{{ $message }}</strong>
            <span class="badge badge-danger">Error</span>
        </span>
    @enderror
</td>
