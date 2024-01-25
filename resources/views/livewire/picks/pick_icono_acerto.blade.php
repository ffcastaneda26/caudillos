    {{-- Icono si acertó/falló o aún no se sabe --}}
    <td>

        @if($pick_user && $game->has_result())

            @if($acerto)
                <img src="{{ asset('images/afirmativo.png') }}" width="25" height="25">
             @else
                <img src="{{ asset('images/negativo.png') }}"   width="25" height="25">
            @endif
        @else
            <img src="{{ asset('images/vs.png') }}" alt="X" width="25" height="25">
        @endif
    </td>

