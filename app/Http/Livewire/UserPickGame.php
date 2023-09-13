<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\User;
use Livewire\Component;

class UserPickGame extends Component
{
    // Redibimos
    public $user;

    // Devolvemos
    public $user_pick_round=null;
    public $allow_pick = false;
    public $game;

    public function mount(User $user,Game $game){
        $this->game = $game;
        $this->user_pick_round = $user->picks_game($game->id)->first();
        $this->allow_pick = $this->game->allow_pick();
    }


    public function render()
    {
        return view('livewire.results.user-pick-game');
    }
}
