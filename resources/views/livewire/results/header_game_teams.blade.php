<thead class="thead">
    <tr class="bg-dark text-white text-center text-sm">
        {{-- <th>Id</th> --}}
        <th>Participante</th>
        @foreach ($round_games as $game)
            <td>{{ $game->visit_team->short }} - {{ $game->local_team->short }}</td>
        @endforeach
    </tr>
</thead>
