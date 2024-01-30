<td align="center">
    <input type="radio"
            wire:model="winner"
<<<<<<< HEAD
            wire:click="update_winner_game"
            name="winner-game{{ $game->id }}"
=======
>>>>>>> 7efd82e6bdc81cffa3318fe657afb8bcc9bb40cc
            value="2"
            {{ !$allow_pick ? 'disabled' : '' }}
            {{ isset($pick_user) && $pick_user->winner == 2 ? 'checked' : '' }}
    />
</td>

{{-- Icono si acertó/falló o aún no se sabe --}}
@if( $game->has_result())
    @include('livewire.picks.pick_icono_acerto')
@endif

{{-- Pronostica que gana Local --}}
<td align="center">
    <input type="radio"
<<<<<<< HEAD
                wire:model="winner"
                 wire:click="update_winner_game"
                name="winner-game{{ $game->id }}"
=======
                wire:model='winner'
>>>>>>> 7efd82e6bdc81cffa3318fe657afb8bcc9bb40cc
                value="1"
                {{ !$allow_pick  ? 'disabled' : '' }}
                {{ isset($pick_user) && $pick_user->winner == 1 ? 'checked' : ''}}
        />

</td>
