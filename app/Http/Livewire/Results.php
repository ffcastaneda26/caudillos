<?php

namespace App\Http\Livewire;

use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Results extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CrudTrait;
    use FuncionesGenerales;

    protected $listeners = ['receive_round'];

    public $users_with_picks_round= null;
    public $cols_show= [];

    public function mount(){
        $round = new Round();
        $this->current_round = $round->read_current_round();
        $this->selected_round =$this->current_round;
        $this->receive_round($this->selected_round );
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */
    public function render(){
        return view('livewire.results.index', [
            'records' => User::role('participante')
                            ->select('users.*')
                            ->Join('picks', 'picks.user_id', '=', 'users.id')
                            ->Join('games', 'picks.game_id', '=', 'games.id')
                            ->where('games.round_id',$this->selected_round->id)
                            ->where('users.active','1')
                            ->groupBy('users.id')
                            ->paginate($this->pagination),
        ]);
    }


    /*+------------------------------------+
      | Recibe Jornada y selecciona juegos |
      +------------------------------------+
    */
    public function receive_round(Round $round){
        if($round){
            $this->selected_round = $round;
            $this->round_games  = $this->selected_round->games()->orderby('game_day')->orderby('game_time')->get();
        }
    }
}
