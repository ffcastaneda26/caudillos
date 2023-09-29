<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use App\Models\GeneralPosition;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Games extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CrudTrait;
    use FuncionesGenerales;

    protected $listeners = ['receive_round'];

    protected $rules = [
        'main_record.round_id' => 'required|exists:rounds,id',
        'main_record.local_team_id' => 'required|exists:teams,id',
        'main_record.visit_team_id' => 'required|exists:teams,id',
        'main_record.game_day'      => 'required',
        'main_record.game_time'     => 'required',
        'main_record.local_points'  => 'nullable|numeric',
        'main_record.visit_points'  => 'nullable|numeric',

    ];

    public $error_message = null;
    public $error= null;
    public $min_date = null;
    public $max_date = null;

    public function mount(){
        $this->manage_title = 'Gestionar Juegos';
        $this->search_label = 'Jornada';
        $this->view_search  =  null;
        $this->view_form    = 'livewire.games.form';
        $this->view_table   = 'livewire.games.table';
        $this->view_list    = 'livewire.games.list';
        $this->rounds       = $this->read_rounds();
        $this->teams        = $this->read_teams();
        $this->allow_create = false;
        $this->main_record  = new Game();
        $this->sort         = 'round_id';
        $round = new Round();
        $this->current_round = $round->read_current_round();
        $this->selected_round =$this->current_round;
        $this->receive_round($this->current_round );
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    public function render(){

        $this->create_button_label = $this->main_record->id ?  'Actualizar Juego' :  ' Crear Juego';

        return view('livewire.games.index');
    }


    /*+---------------+
    | Guarda Registro |
    +-----------------+
    */

    public function store(){
        $this->reset('error_message');
        $this->validate();

        if(strlen($this->main_record->visit_points) && strlen($this->main_record->local_points) < 1 ){
            $this->error_message = 'Falta Marcador Local';
            return false;
        }

        if(strlen($this->main_record->local_points) && strlen($this->main_record->visit_points) < 1 ){
            $this->error_message = 'Falta Marcador Visita';
            return false;
        }

        $this->main_record->winner = null;
        if(!$this->main_record->visit_points){
            $this->main_record->visit_points = 0;
        }

        if(!$this->main_record->local_points){
            $this->main_record->local_points = 0;
        }

        if($this->main_record->visit_points && $this->main_record->visit_points == $this->main_record->local_points){
            $this->error_message = 'Los marcadores deben ser diferentes, no se permiten empates';
            return false;
        }


        $this->main_record->winner = $this->main_record->win();
        $this->main_record->save();

        // Si se pusieron puntos se procede a calificar pronósticos
        if($this->main_record->local_points || $this->main_record->visit_points){
            $this->qualify_picks();        // Califica pronósticos
            if($this->main_record->is_last_game_round()){
                $this->update_hit_last_game($this->main_record); // ¿Acertó último partido?
                $this->update_tie_breaker($this->main_record);
            }
            $this->update_total_hits_positions( $this->selected_round); // Actualiza tabla de aciertos por jornada (POSITIONS)
            $this->update_positions(); // Asigna posiciones en tabla de POSITIONS
            $this->read_general_positions(); // Lee posicions generales
            $general_position = new GeneralPosition();
            $positions = $this->read_general_positions();
            if($positions){
                $general_position->truncate_me();
                $general_position->create_positions($positions);
            }
        }

        $this->show_alert('success','JUEGO ACTUALIZADO SATISFACTORIAMENTE');
        $this->receive_round( $this->main_record->round);
        $this->close_store('Juego');
    }

    // Restaura campos
    public function resetInputFields(){
        $this->main_record = new Game();
        $this->resetErrorBag();
    }


    /*+------------------------------+
    | Lee Registro Editar o Borar  |
    +------------------------------+
    */

    public function edit(Game $record){
        $this->main_record  = $record;
        $this->record_id    = $record->id;
        $this->openModal();
    }

    /*+----------------+
      | Recibe Jornada |
      +----------------+
    */

    public function receive_round(Round $round){
        if($round){
            $this->selected_round = $round;
            $this->round_games = $this->selected_round->games()->orderby('id')->get();
        }
    }

    private function consulta(){
        $dif_victoria = $this->main_record->local_points + $this->main_record->visit_points ;
        $consulta = "UPDATE picks pic,games ga ";
		$consulta.="SET ";
		$consulta.="pic.dif_points_local=abs(".$this->main_record->local_points."-pic.local_points),";
		$consulta.="pic.dif_points_visit= abs(".$this->main_record->visit_points ."-pic.visit_points),";
		$consulta.="pic.dif_points_total= abs(abs(". $this->main_record->visit_points . "-pic.visit_points)+abs(". $this->main_record->local_points."-pic.local_points)),";
		$consulta.="hit_local= CASE WHEN pic.local_points=". $this->main_record->local_points . " THEN 1 ELSE 0  END,";
		$consulta.="hit_visit= CASE WHEN pic.visit_points=". $this->main_record->visit_points  ." THEN 1 ELSE 0  END,";
		//$consulta.="acerto_ultimo_partido=pic.nivelacierto,";
		$consulta.="dif_points_winner= CASE WHEN (" . $this->main_record->local_points . ">". $this->main_record->visit_points  . ") THEN abs(pic.local_points - " . $this->main_record->local_points . ") ELSE abs(pic.visit_points - " . $this->main_record->visit_points  . ")  END,";
		$consulta.="pic.dif_victory=abs(" . $dif_victoria . "-(pic.local_points + pic.visit_points)) ";
		$consulta.="WHERE ga.id = pic.game_id ";
		$consulta.="  AND ga.id=" . $this->main_record->id;

    }

}
