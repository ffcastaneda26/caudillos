<?php

namespace App\Http\Livewire\Picks;

use App\Models\Game;
use App\Models\Pick;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class PickGame extends Component
{
    // Parámetros que se reciben
    public $game;
    public $id_game_tie_breaker;

    // Para las vistas y hacer la lógica en el backend

    public $game_month;
    public $game_day;
    public $game_date;
    public $pick_user;
    public $pick_user_winner;
    public $allow_pick;
    public $game_has_result;
    public $acerto;
    public $hit_pick_hame;
    public $is_game_tie_breaker;


    // Para actualizar pronósticos
    public $winner;
    public $visit_points;
    public $local_points;


    protected $rules = [
        'winner' => 'required|in:1,2',
        'visit_points' => 'required|different:local_points',
        'local_points' => 'required|different:visit_points',
    ];

    public function messages(): array
    {
        return [
            'visit_points.required' => 'Indique puntos',
            'visit_points.different'=> 'No Empates',
            'local_points.required' => 'Indique puntos',
            'local_points.different'=> 'No Empates',
        ];
    }


    public function mount(Game $game,$id_game_tie_breaker){
        $this->id_game_tie_breaker = $id_game_tie_breaker;
        $this->game = $game;
        $this->prepare_data_to_view();
    }

    public function render()
    {
        return view('livewire.picks.pick_game.pick-game');
    }

    /*+-------------------------------------------------+
      | Llena las variables que se utilizan en la vista |
      | Para evitar que se realicen consultas a la BD   |
      | desde las mismas                                |
      +-------------------------------------------------+
     */
    public function prepare_data_to_view(){
        $this->game_day = date('j', $this->game_date);
        $this->game_month = date('n',$this->game_date);
        $this->allow_pick = $this->game->allow_pick();
        $this->game_has_result = $this->game->has_result();
        $this->is_game_tie_breaker = $this->game->is_game_tie_breaker();
        $this->pick_user = $this->game->pick_user();
        if(!$this->pick_user){
            $this->pick_user =  $this->create_pick_user_game();
        }
        $this->pick_user_winner = $this->pick_user->winner;
        $this->acerto = $this->game_has_result && $this->pick_user_winner === $this->game->winner;
        $this->visit_points =  $this->pick_user->visit_points;
        $this->local_points =  $this->pick_user->local_points;

    }

    public function update_winner_game()
    {
        $this->validateOnly('winner');
        $this->pick_user->winner = $this->winner;
        $this->pick_user->save();
        $this->pick_user->refresh();
        $this->pick_user_winner = $this->pick_user->winner;
    }

    public function update_points(){
        $this->validateOnly('visit_points');
        $this->validateOnly('local_points');
        $this->winner = $this->local_points > $this->visit_points ? 1 : 2;

        if($this->visit_points == $this->local_points){
            $this->errors->add('visit_points', 'No Empate');
            $this->errors->add('local_points', 'No Empate');
            return;
        }

        $pick_user = $this->game->pick_user();
        if($pick_user){
            $pick_user->visit_points = $this->visit_points;
            $pick_user->local_points = $this->local_points;
            $pick_user->winner = $this->local_points > $this->visit_points ? 1 : 2;
            $pick_user->save();
        }
    }

    // Crea pronóstico para el usuario en este partido
    private function create_pick_user_game(){
        $winner = mt_rand(1, 2);
        $new_pick = Pick::create([
            'user_id'   => Auth::user()->id,
            'game_id'   => $this->game->id,
            'winner'    => $winner
        ]);

        if ($this->id_game_tie_breaker == $this->game->id) {
            if ($winner == 1) {
                $new_pick->local_points = random_int(3, 48);
                $new_pick->visit_points = 0;
            } else {
                $new_pick->local_points = 0;
                $new_pick->visit_points = random_int(3, 48);
            }
            $new_pick->winner= $new_pick->local_points > $new_pick->visit_points ? 1 : 2;
        }
        $new_pick->save();
        return $new_pick;
    }
}
