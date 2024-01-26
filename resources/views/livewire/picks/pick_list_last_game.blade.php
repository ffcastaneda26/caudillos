<td align="center">
    <input type='number' wire:model="points_visit_last_game" min=0 max=127 style="font-size: 8px"
        class="w-auto {{ $error == 'visit' || $error == 'tie' ? 'bg-red-500' : '' }}"
        {{ $allow_pick ? '' : 'disabled' }}>
</td>
{{-- Icono si acertó/falló o aún no se sabe --}}
@if ($game->has_result())
    @include('livewire.picks.pick_icono_acerto')
@endif
<td align="center">
    <input type='number' wire:model="points_local_last_game" min=0 max=127 style="font-size: 8px"
    class="w-auto text-center  {{ $error == 'local' || $error == 'tie' ? 'bg-red-500' : '' }}"
    {{ $allow_pick ? '' : 'disabled' }}>
</td>
