<?php

namespace App\Http\Livewire\Picks;

use App\Models\Game;
use Livewire\Component;

class PickGame extends Component
{
    public $game;
    public $id_game_last_game_round;

    public $allow_pick;
    public $is_last_game;
    public $is_game_tie_breaker;
    public $is_last_game_round_to_pick;
    public $pick_user;

    public $print_score;
    public $game_date;
    public $game_month;
    public $game_day;

    public $acerto;

    public $visit_points;
    public $local_points;

    public $winner;
    public $error;

    public function mount(Game $game){
        $this->charge_data();
    }

    public function render()
    {
        return view('livewire..picks.pick-game');
    }

    public function charge_data(){
        $this->game_date = strtotime($this->game->game_day);
        $this->game_month = date('n', $this->game_date);
        $this->game_day = date('j', $this->game_date);
        $this->allow_pick = $this->game->allow_pick();
        $this->is_last_game = $this->game->is_last_game_round();
        $this->is_game_tie_breaker = $this->game->is_game_tie_breaker();
        $this->is_last_game_round_to_pick = $this->game->is_last_game_round_to_pick();
        $this->pick_user = $this->game->pick_user();
        $this->print_score = $this->game->print_score();
        $this->acerto = $this->game->has_result() && $this->pick_user && $this->pick_user->winner == $this->game->winner;
        $this->game_date = strtotime($this->game->game_day);
        $this->game_month = date('n', $this->game_date);
        $this->game_day = date('j', $this->game_date);

    }
}
