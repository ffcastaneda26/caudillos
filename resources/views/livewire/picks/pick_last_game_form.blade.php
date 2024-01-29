{{-- Campos para puntos del último partido --}}
<table class="table table-striped table-hover text-xs">
    <tr>
        <td class="bg-dark text-white text-end text-transform: uppercase"">Introduzca los puntos para el último partido</td>
        <td class="input-group-text text-end">VISITA</td>
        <td><input type='number' wire:model="points_visit_last_game" min=0  max=127 class="input-group-text"> </td>
        <td  class="input-group-text text-start"> LOCAL</td>
        <td><input type='number' wire:model="points_local_last_game"min=0 max=127 class="input-group-text"></td>
    </tr>
    @if(isset($message))
        <tr class="text-red-600 text-danger text-center text-3xl">
            <td>{{ $message }}</td>
        </tr>
    @endif
</table>
