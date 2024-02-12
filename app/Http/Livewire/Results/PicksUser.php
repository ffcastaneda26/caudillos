<?php

namespace App\Http\Livewire\Results;

use App\Models\Game;
use Livewire\Component;
use App\Http\Livewire\Traits\FuncionesGenerales;

class PicksUser extends Component
{
    use FuncionesGenerales;
    public $pick_user;
    public $is_game_tie_breaker;

    // Pronóstico del partido

    public $game;
    public $allow_pick;
    public $game_has_result;
    public $hit_game;
    public $visit_points;
    public $local_points;
    // Pronóstico del partido de desempate
    public $is_tie_breaker_game = null;
    public $tie_breaker_game =null;
    public $tie_breaker_game_allow_pick =false;
    public $tie_breaker_game_has_result =false;
    public $tie_breaker_game_hit_game=false;

    // Si ya está en la tabla de posiciones

    public $user_has_position_in_round = false;
    public $user_round_position =null;

    public function mount(){
        $this->prepare_data_to_view();
    }

    public function render()
    {
        return view('livewire.results.picks-user');
    }

    /*+-------------------------------------------------+
      | Llena las variables que se utilizan en la vista |
      | Para evitar que se realicen consultas a la BD   |
      | desde las mismas                                |
      +-------------------------------------------------+
     */
    public function prepare_data_to_view(){
        $this->game = $this->pick_user->game;

        $this->allow_pick       = $this->game->allow_pick();
        $this->game_has_result  = $this->game->has_result();
        $this->hit_game         = $this->game->hit_game($this->pick_user->winner );
        $this->visit_points =  $this->pick_user->visit_points;
        $this->local_points =  $this->pick_user->local_points;

        $this->is_tie_breaker_game = $this->id_game_tie_breaker === $this->game->id;
        if($this->is_tie_breaker_game){
            $this->tie_breaker_game = Game::FindOrFail($this->id_game_tie_breaker);
            $this->tie_breaker_game_allow_pick  =  $this->tie_breaker_game->allow_pick();
            $this->tie_breaker_game_has_result  =  $this->tie_breaker_game->has_result();
            $this->tie_breaker_game_hit_game    =  $this->tie_breaker_game->hit_game($this->pick_user->winner);
        }

        // Para ver si ya tiene posición en la jornada
        $this->user_has_position_in_round =  $this->pick_user->user->has_position_record_round($this->game->round_id);
        if($this->user_has_position_in_round){
            $this->user_round_position = $this->pick_user->user->hits_round($this->game->round_id);
        }
    }


    private function show_data_pick(){
        dd('LOS VALORES CALCULADOS PARA ESTE USUARIO SON',
           'Partido=' . $this->game->id . ' Visita=' . $this->game->visit_team->alias . ' vs ' . $this->game->local_team->alias,
           'Permite pronosticar=' . $this->allow_pick,
           'Tiene resultados=' . $this->game_has_result,
           'Acertó pronóstico=' . $this->hit_game,
           'Pronostico Visita=' . $this->visit_points,
           'Pronostico Local=' . $this->local_points,
           'A que gana entonces=' , $this->pick_user->winner == 1 ? 'LOCAL' : 'VISITA',
           'Es Partido de desempate=' , $this->is_game_tie_breaker ? 'SI' : 'NO',
           'PD permite pronosticar=' . $this->tie_breaker_game_allow_pick,
           'PD Tiene resultados=' . $this->tie_breaker_game_has_result ,
           'PD Acertado por participante=' . $this->tie_breaker_game_hit_game);
    }
}

