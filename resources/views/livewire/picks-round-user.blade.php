<div class="mt-2">
    <td>{{ $user->name }}</td>
    @foreach($user_picks_round as $user_pick_round)
        <td align="center">
            @if($user_pick_round->game->allow_pick())
                <img src="{{ asset('images/reloj.jpg') }}" alt="" width="32px" height="32px">
            @else
                @if($user_pick_round->winner== 1)
                    <label class="text-sm">{{ $user_pick_round->game->local_team->name}}</label>

                    {{-- <label class="{{ $user_pick_round->winner== $user_pick_round->game->winner ? 'bg-danger' : 'bg-success' }}">{{ $user_pick_round->game->local_team->name}}</label> --}}
                @else
                    <label class="text-sm">{{ $user_pick_round->game->visit_team->name}}</label>
                    {{-- <label class="{{ $user_pick_round->winner== $user_pick_round->game->winner ? 'bg-danger' : 'bg-success' }}">{{ $user_pick_round->game->visit_team->name}}</label> --}}
                @endif
                <span>
                    <img src="{{ $user_pick_round->winner== $user_pick_round->game->winner  ?   asset('images/afirmativo.png') : asset('images/negativo.png')}}"
                                alt="{{$user_pick_round->winner== $user_pick_round->game->winner  ?  __('Yes') : 'No' }}"
                                height="12px"
                                width="12px">
                </span>

            @endif

        </td>
    @endforeach
</div>

