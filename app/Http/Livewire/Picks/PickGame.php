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

<<<<<<< HEAD
    protected $rules = [
        'winner' => 'required|in:1,2',
        'visit_points' => 'required|different:local_points|lt:128',
        'local_points' => 'required|different:visit_points|lt:128',
    ];

    public function messages(): array
    {
        return [
            'visit_points.required' => 'Indique puntos',
            'visit_points.different'=> 'No Empates',
            'visit_points.lt'       => 'Máximo 127',
            'local_points.required' => 'Indique puntos',
            'local_points.different'=> 'No Empates',
            'local_points.lt'       => 'Máximo 127',
        ];
    }


    public function mount(Game $game,$id_game_last_game_round){
        $this->id_game_last_game_round = $id_game_last_game_round;
        $this->game = $game;
=======
    public function mount(Game $game){
>>>>>>> 7efd82e6bdc81cffa3318fe657afb8bcc9bb40cc
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
<<<<<<< HEAD
       // $this->is_last_game = $this->game->is_last_game_round();
=======
        $this->is_last_game = $this->game->is_last_game_round();
>>>>>>> 7efd82e6bdc81cffa3318fe657afb8bcc9bb40cc
        $this->is_game_tie_breaker = $this->game->is_game_tie_breaker();
        $this->is_last_game_round_to_pick = $this->game->is_last_game_round_to_pick();
        $this->pick_user = $this->game->pick_user();
        $this->print_score = $this->game->print_score();
        $this->acerto = $this->game->has_result() && $this->pick_user && $this->pick_user->winner == $this->game->winner;
        $this->game_date = strtotime($this->game->game_day);
        $this->game_month = date('n', $this->game_date);
        $this->game_day = date('j', $this->game_date);
<<<<<<< HEAD
    }

    public function update_winner_game()
    {
        $this->validateOnly('winner');

        $pick_user = $this->game->pick_user();
        if($pick_user){
            $pick_user->winner = $this->winner;
            $pick_user->save();
        }
    }

    public function update_points(){
        $this->validateOnly('visit_points');
        $this->validateOnly('local_points');
        $this->winner = $this->local_points > $this->visit_points ? 1 : 2;
        if($this->visit_points == $this->local_points){
            $this->errors->add('visit_points', 'No puede ser empate');
            return;
        }


        $pick_user = $this->game->pick_user();
        if($pick_user){
            $pick_user->visit_points = $this->visit_points;
            $pick_user->local_points = $this->local_points;
            $pick_user->winner = $this->local_points > $this->visit_points ? 1 : 2;
            $pick_user->save();
        }
=======

>>>>>>> 7efd82e6bdc81cffa3318fe657afb8bcc9bb40cc
    }
}
