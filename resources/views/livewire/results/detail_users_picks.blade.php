@php
$participante_anterior = null;
$previous_pick = null;
@endphp

@foreach ($round_picks as $pick)

    @if($pick->user_id != $participante_anterior)
        @if(!is_null($previous_pick))
            @if($previous_pick->game->allow_pick())
                <td align="center">
                    <x-reloj-image/>>
                </td>
            @else
            <td align="center" class="{{  $previous_pick->hit ? 'bg-success' : 'bg-danger' }}">
                    <img src="{{ $previous_pick->winner == 1 ? Storage::url($previous_pick->game->local_team->logo) : Storage::url($previous_pick->game->visit_team->logo) }}"
                        alt="{{ $previous_pick->winner == 1 ? $previous_pick->game->local_team->short : $previous_pick->game->visit_team->short }}"
                        width="45px"
                        height="45px">
                    <span>
                        <img src="{{ $previous_pick->hit  ?   asset('images/afirmativo.png') : asset('images/negativo.png')}}"
                                    alt="{{ $pick->hit  ?  __('Yes') : 'No' }}"
                                    height="12px"
                                    width="12px">
                    </span>
                </td>
            @endif
        @endif
        </tr>
        <td>{{ $pick->user->name }}</td>
    @endif

    @if($pick->user_id == $participante_anterior)
            @if($pick->game->allow_pick())
                <td align="center">
                    <x-reloj-image/>>
                </td>
            @else
            <td align="center" class="{{  $pick->hit ? 'bg-success' : 'bg-danger' }}">
                    <img src="{{ $pick->winner == 1 ? Storage::url($pick->game->local_team->logo) : Storage::url($pick->game->visit_team->logo) }}"
                        alt="{{ $pick->winner == 1 ? $pick->game->local_team->short : $pick->game->visit_team->short }}"
                        width="45px"
                        height="45px">
                    <span>
                        <img src="{{ $pick->hit  ?   asset('images/afirmativo.png') : asset('images/negativo.png')}}"
                                    alt="{{ $pick->hit  ?  __('Yes') : 'No' }}"
                                    height="12px"
                                    width="12px">
                    </span>
                </td>
            @endif
    @endif

    @php
        $participante_anterior = $pick->user_id;
        $previous_pick = $pick;
    @endphp
@endforeach
    @if(!is_null($previous_pick))
    @if($previous_pick->game->allow_pick())
    <td align="center">
        <x-reloj-image/>>
    </td>
@else
    <td align="center" class="{{  $previous_pick->hit ? 'bg-success' : 'bg-danger' }}">
            <img src="{{ $previous_pick->winner == 1 ? Storage::url($previous_pick->game->local_team->logo) : Storage::url($previous_pick->game->visit_team->logo) }}"
                alt="{{ $previous_pick->winner == 1 ? $previous_pick->game->local_team->short : $previous_pick->game->visit_team->short }}"
                width="45px"
                height="45px">
            <span>
                <img src="{{ $previous_pick->hit  ?   asset('images/afirmativo.png') : asset('images/negativo.png')}}"
                            alt="{{ $pick->hit  ?  __('Yes') : 'No' }}"
                            height="12px"
                            width="12px">
            </span>
        </td>
    @endif
@endif
