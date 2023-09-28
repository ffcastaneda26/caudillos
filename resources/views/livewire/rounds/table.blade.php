<thead>
    <tr class="bg-dark text-white text-center">
        <th class="px-4 py-2"
            wire:click="order('start_date')">
            @if($sort == 'start_date')
                @if($direction == 'asc')
                    <span class="float-right"><i class="mdi mdi-arrow-up "></i></span>
                @else
                    <span class="float-right"><i class="mdi mdi-arrow-down"></i></span>
                @endif
            @else
                <span class="float-right"><i class="mdi mdi-sort"></i></span>

            @endif
            Fecha Inicio
        </th>

        <th class="px-4 py-2"
            wire:click="order('end_date')">
            @if($sort == 'end_date')
                @if($direction == 'asc')
                    <span class="float-right"><i class="mdi mdi-arrow-up "></i></span>
                @else
                    <span class="float-right"><i class="mdi mdi-arrow-down"></i></span>
                @endif
            @else
                <span class="float-right"><i class="mdi mdi-sort"></i></span>

            @endif
            Fecha Final
        </th>

        <th>¿Es la Activa?</th>
        <th>Tipo</th>
        <th colspan="2" class="px-4 py-2">Acciones</th>
    </tr>
</thead>
