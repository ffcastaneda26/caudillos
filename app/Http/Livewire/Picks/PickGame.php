<?php

namespace App\Http\Livewire\Picks;

use Carbon\Carbon;
use App\Models\Game;
use App\Models\Pick;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Traits\FuncionesGenerales;

class PickGame extends Component
{
    use FuncionesGenerales;

    // Parámetros que se reciben
    public $game;
    public $configuration;
    public $is_game_tie_breaker;


    // Para las vistas y hacer la lógica en el backend
    public $game_month;
    public $game_day;
    public $game_date;
    public $pick_user;
    public $pick_user_winner;
    public $allow_pick;
    public $game_has_result;
    public $hit_game;
    public $hit_pick_hame;


    // Errores:
    public $local_error = null;
    public $visit_error = null;

    // Para actualizar pronósticos
    public $winner;
    public $visit_points;
    public $local_points;


    public function mount(Game $game,$id_game_tie_breaker,$configuration){
        $this->id_game_tie_breaker = $id_game_tie_breaker;
        $this->game = $game;
        $this->configuration = $configuration;

        $this->prepare_data_to_view();
    }

    public function render()
    {
        return view('livewire.picksgames.pick-game');
    }

    /*+-------------------------------------------------+
      | Llena las variables que se utilizan en la vista |
      | Para evitar que se realicen consultas a la BD   |
      | desde las mismas                                |
      +-------------------------------------------------+
     */
    public function prepare_data_to_view(){
        $this->game_day = substr(date($this->game->game_day),8,2);
        $this->game_month = $this->months_short_spanish[substr(date($this->game->game_day),5,2)-1];

        $this->allow_pick = $this->game->allow_pick();

        $this->game_has_result = $this->game->has_result();
        $this->is_game_tie_breaker = $this->id_game_tie_breaker == $this->game->id;

        $this->pick_user = $this->game->pick_user();
        if(!$this->pick_user){
            $this->pick_user = $this->create_pick_user_game($this->game,Auth::user());
        }
        $this->winner = $this->pick_user->winner;
        $this->pick_user_winner = $this->pick_user->winner;
        $this->hit_game = $this->game_has_result && $this->pick_user_winner === $this->game->winner;

        $this->visit_points =  $this->pick_user->visit_points;
        $this->local_points =  $this->pick_user->local_points;

    }

    public function update_winner_game()
    {
        $this->validateOnly('winner');
        $this->pick_user->winner = $this->pick_user_winner;
        $this->pick_user->save();
        $this->pick_user->refresh();
    }

    public function update_points(){

        $this->local_points = ltrim($this->local_points, "0");
        $this->visit_points = ltrim($this->visit_points, "0");


        $this->winner = $this->local_points > $this->visit_points ? 1 : 2;

        $this->validate([
            'visit_points' => 'required|different:local_points|not_in:1',
            'local_points' => 'required|different:visit_points|not_in:1',
        ], [
            'visit_points.required' => 'Indique puntos',
            'visit_points.different' => 'No Empates',
            'visit_points.not_in' => 'No Permitido',
            'local_points.required' => 'Indique puntos',
            'local_points.different' => 'No Empates',
            'local_points.not_ind' => 'No Permitido',
        ]);

        if ($this->visit_points == $this->local_points) {
            $this->addError('visit_points', 'No Empates');
            $this->addError('local_points', 'No Empates');
            return;
        }
        // TODO:: Revisar si se cambió el partido de desempate hay que quitar los puntos al anterior
        $pick_user = $this->game->pick_user();
        if($pick_user){
            $pick_user->visit_points = $this->visit_points;
            $pick_user->local_points = $this->local_points;
            $pick_user->winner = $this->local_points > $this->visit_points ? 1 : 2;
            $pick_user->save();
        }
    }

    // Crea pronóstico para el usuario en este partido
    private function create_pick_user_gamex(){
        $winner = mt_rand(1, 2);
        $new_pick = Pick::create([
            'user_id'   => Auth::user()->id,
            'game_id'   => $this->game->id,
            'winner'    => $winner
        ]);


        if($this->configuration->require_points_in_picks){
            if ($winner == 1) {
                $new_pick->local_points = random_int(3, 48);
                $new_pick->visit_points = 0;
            } else {
                $new_pick->local_points = 0;
                $new_pick->visit_points = random_int(3, 48);
            }
            $new_pick->winner= $new_pick->local_points > $new_pick->visit_points ? 1 : 2;

        }else{
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
        }

        $new_pick->save();
        return $new_pick;
    }
}
