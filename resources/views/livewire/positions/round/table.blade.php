<thead class="thead">
    <tr align="center" class="bg-dark text-white text-center" style="vertical-align: middle">
        <th>Pos</th>
        <th >Participante </th>
        <th>Aciertos</th>
        @if (isset($tie_breaker_game_played))
            <th>
                @if ($tie_breaker_game->winner == 1)
                    <img src="{{ Storage::url($tie_breaker_game->local_team->logo) }}" class="avatar-xs md:w-100 h-100">
                @else
                    <img src="{{ Storage::url($tie_breaker_game->visit_team->logo) }}" class="avatar-xs md:w-100 h-100">
                @endif
            </th>
            <th>{{ $tie_breaker_game->visit_points . '-'  . $tie_breaker_game->local_points }}</th>
        @else
            <th style="text-align: center;">
                    <x-reloj-image/>
            </th>
        @endif

        @if ($tie_breaker_game_played)
            <th>¿Partido Desempate?</th>
            <th>Error Local + Error Visita</th>
            <th>Menor Error Puntos</th>
            <th>Menor Error Ganador</th>
            <th>Menor Error Puntos Totales</th>
        @endif
    </tr>
</thead>
