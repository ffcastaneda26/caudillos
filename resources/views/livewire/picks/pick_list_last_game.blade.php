<td>
    <input type='number' wire:model="points_visit_last_game" min=0 max=127 style="font-size: 10px"
        class="w-20 {{ $error == 'visit' || $error == 'tie' ? 'bg-red-500' : '' }}"
        {{ $allow_pick ? '' : 'disabled' }}>
</td>
{{-- Icono si acertó/falló o aún no se sabe --}}
@if ($game->has_result())
    @include('livewire.picks.pick_icono_acerto')
@endif
<td class="text-xs">
    <input type='number' wire:model="points_local_last_game" min=0 max=127 style="font-size: 10px"
        class="w-20  {{ $error == 'local' || $error == 'tie' ? 'bg-red-500' : '' }}"
        {{ $allow_pick ? '' : 'disabled' }}>
</td>
