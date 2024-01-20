<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\User;
use Livewire\Component;

class UserPickGame extends Component
{
    // Redibimos
    public $user;
    public $game;
    public $pick;

    // Devolvemos
    public $user_pick_round=null;
    public $allow_pick  = false;
    public $has_result  = false;
    public $hit_game    = false;


    public function mount(User $user,Game $game){
        $this->user= User::findOrFail($this->pick->user_id);
        $this->game= Game::findOrFail($this->pick->game_id);
        $this->user_pick_round  = $user->picks_game($game->id)->first();
        $this->allow_pick       = $this->game->allow_pick();
        $this->has_result       = $this->game->has_result();
        $this->hit_game         = $this->pick->winner == $this->game->winner;
    }


    public function render()
    {

        return view('livewire.results.user-pick-game');
    }

    private function show_data(){
        dd('Game',$this->game,'User_pick_round' , $this->user_pick_round,'Allow_pick' . $this->allow_pick,'Has Result=' . $this->has_result,'Hit Game=' . $this->hit_game);
    }

    private function read_data(){
        $this->user= User::findOrFail($this->pick->user_id);
        $this->game= Game::findOrFail($this->pick->game_id);
        $this->user_pick_round  = $this->user->picks_game($this->game->id)->first();
        $this->allow_pick       = $this->game->allow_pick();
        $this->has_result       = $this->game->has_result();
        $this->hit_game         = $this->pick->winner == $this->game->winner;
    }

}
