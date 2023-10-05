<thead class="thead">
    <tr class="bg-dark text-white text-center">
        <th>Pos</th>
        <th>Participante  </th>
        <th>Aciertos</th>
        @if($tie_breaker_game_played)
            <th>¿Partido Desempate?</th>
            <th>Error Local + Error Visita</th>
            <th>Error Puntos Ganador</th>
            <th colspan="2">Marcador Total</th>
        @endif
    </tr>
</thead>
