<div class="mt-2">
    <td class="text-base w-40">{{ $user->name }}</td>
        @foreach($cols_show as $col_show)
            @if( $col_show)
                @livewire('user-pick-game', ['user'   => $user,'game'=> $col_show], key($user->id))
           @else
                <td class="text-base text-center">No Jugó</td>
           @endif
        @endforeach

    <td class="text-base text-center text-2xl">
        {{ $user->has_position_record_round($round->id) ? $user->hits_round($round->id) : ''}}
    </td>
</div>

