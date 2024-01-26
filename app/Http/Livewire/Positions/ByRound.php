<?php

namespace App\Http\Livewire\Positions;

use App\Models\Game;
use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Configuration;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ByRound extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;
    use CrudTrait;
    use FuncionesGenerales;

    protected $listeners = ['receive_round'];


    public $order_by = 'hits_desc';


    public function mount(){
        $this->manage_title = 'Posiciones x Jornada';
        $this->view_table   = null;
        $this->view_list    = null;
        $round = new Round();
        $this->current_round = $round->read_current_round();
        $this->selected_round =$this->current_round;
        $this->receive_round($this->current_round );
        $this->tie_breaker_game_has_played();
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */

    public function render(){
        return view('livewire.positions.round.index', [
            'records' => $this->read_data(),
        ]);

    }

    /*+------------------------------------+
      | Lee datos                           |
      +------------------------------------+
    */

    private function read_data()
    {

        switch ($this->order_by) {
            case 'name_asc':
                $this->sort = 'name';
                $this->direction = 'asc';
                break;
            case 'name_desc':
                $this->sort = 'name';
                $this->direction = 'desc';
                break;
            case 'hits_asc':
                $this->sort = 'hits';
                $this->direction = 'asc';
                break;
            case 'hits_desc':
                $this->sort = 'hits';
                $this->direction = 'desc';
                break;
            default:
                $this->sort = 'hits';
                $this->direction = 'desc';
                break;
        }

        $results = DB::table('users as us')
                ->join('positions as po', 'us.id', '=', 'po.user_id')
                ->join('rounds as ro', 'ro.id', '=', 'po.round_id')
                ->where('ro.id', '=', $this->selected_round->id)
                ->where('us.active', '1')
                ->where('first_name', 'LIKE', "%$this->search%")
                ->orwhere('last_name', 'LIKE', "%$this->search%")
                ->orwhere('email', 'LIKE', "%$this->search%")
                ->select(DB::raw('CONCAT(us.first_name, " ", us.last_name) AS name'), 'po.hits as hits', 'po.position', 'po.hit_last_game','po.dif_total_points','po.best_shot','po.dif_winner_points','po.dif_victory');

                if ($this->sort === 'name') {
                    $results->orderBy(DB::raw('CONCAT(us.first_name, " ", us.last_name)'), $this->direction);
                } else {
                    $results->orderBy('hits', $this->direction);
                }

        $results = $results->paginate($this->pagination);
        return $results;
    }

    /*+---------------+
      | Recibe Jornada |
      +---------------+
    */

    public function receive_round(Round $round){
        if($round){
            $this->selected_round = $round;
        }

    }

}


