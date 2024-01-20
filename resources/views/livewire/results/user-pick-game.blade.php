<div>

    {{-- @dd('Pick de ='. $pick->user->name,'allow_pick=' . $allow_pick,'Pronostica=' . $pick->winner,' Partido tiene resultado=' , $has_result , 'Acertó el partido=' . $hit_game) --}}
    <td align="center">
        @if($allow_pick)
            <img src="{{ asset('images/reloj.png') }}" alt="" width="32px" height="32px">
        @else
            @if($pick->winner== 1)
                <img src="{{Storage::url($game->local_team->logo)}}"  class="avatar-xs">
            @else
                <img src="{{Storage::url($game->visit_team->logo)}}"  class="avatar-xs">
            @endif

            @if($has_result)
                <span>
                    <img src="{{ $hit_game  ? asset('images/afirmativo.png') : asset('images/negativo.png')}}"
                                height="10px"
                                width="10px"
                        >
                </span>
            @endif
        @endif
    </td>
</div>

