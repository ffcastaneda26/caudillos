<thead class="thead">
    <tr class="bg-dark text-white text-center">
        <th>Pos</th>
        <th>Participante  </th>
        <th>Aciertos</th>
        @if($tie_breaker_game_played)
            <th>¿Partido Desempate?</th>
            <th>Error Local + Error Visita</th>
            <th>Menor Error Puntos</th>
            <th>Menor Error Ganador</th>
            <th>Menor Error Puntos Totales</th>
        @endif
    </tr>
</thead>
