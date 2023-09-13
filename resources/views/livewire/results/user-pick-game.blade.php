<div>

    <td align="center">
        @if($allow_pick)
            <img src="{{ asset('images/reloj.jpg') }}" alt="" width="32px" height="32px">
        @else
            @if($user_pick_round->winner== 1)
                <img src="{{Storage::url($user_pick_round->game->local_team->logo)}}"  class="avatar-xs">
            @else
                <img src="{{Storage::url($user_pick_round->game->visit_team->logo)}}"  class="avatar-xs">
            @endif

            @if( $game->has_result())
                <span>
                    <img src="{{ $user_pick_round->winner       == $game->winner  ?   asset('images/afirmativo.png') : asset('images/negativo.png')}}"
                                height="12px"
                                width="12px">
                </span>
            @endif
        @endif
    </td>

</div>
