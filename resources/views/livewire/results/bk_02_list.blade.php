<tr>
    <td align="left">{{ $user->name }}</td>
    @foreach ($selected_round->picks_user($user->id)->get() as $pick)
        @livewire('results.picks-user',
                ['pick_user'             =>  $pick,
                'id_game_tie_breaker'   => $id_game_tie_breaker
                ],key($pick->id))
    @endforeach
</tr>
