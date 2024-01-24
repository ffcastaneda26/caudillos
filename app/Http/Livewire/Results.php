<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Results extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use CrudTrait;
    use FuncionesGenerales;

    protected $listeners = ['receive_round'];

    public $users_with_picks_round = null;
    // public $cols_show = [];
    public $picks_auth_user_round;
    public $sort_secondary = 'last_name';
    public $sort_by = 'name';
    public $order_by = 'name_asc';

    public function mount()
    {

        $round = new Round();
        $this->current_round = $round->read_current_round();
        $this->selected_round = $this->current_round;
        $this->receive_round($this->selected_round);
        $this->picks_auth_user_round =  $this->selected_round->picks_auth_user()->get();
        $this->read_configuration();
        $this->sort = 'name';
        $this->direction = 'asc';
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */
    public function render()
    {

        return view('livewire.results.index', [
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

            case 'picks_asc':
                $this->sort = 'picks';
                $this->direction = 'asc';

            case 'picks_desc':
                $this->sort = 'picks';
                $this->direction = 'desc';


            default:
                $this->sort = 'name';
                $this->direction = 'desc';
        }


        $users = User::role('participante')
            ->join('picks', 'users.id', '=', 'picks.user_id')
            ->join('games', 'picks.game_id', '=', 'games.id')
            ->where('games.round_id', '=', $this->selected_round->id)
            ->where('users.active', '1')
            ->where('first_name', 'LIKE', "%$this->search%")
            ->orwhere('last_name', 'LIKE', "%$this->search%")
            ->orwhere('email', 'LIKE', "%$this->search%")
            ->groupBy('users.id')
            ->select('users.*', DB::raw('SUM(picks.hit) as total_hits'));
        if ($this->sort === 'name') {
            $users->orderBy(DB::raw('CONCAT(users.first_name, " ", users.last_name)'), $this->direction);
        } else {
            $users->orderBy(DB::raw('SUM(picks.hit)'), $this->direction);
        }

        $users = $users->paginate($this->pagination);
        return $users;
    }

    /*+------------------------------------+
      | Recibe Jornada y selecciona juegos |
      +------------------------------------+
    */
    public function receive_round(Round $round)
    {

        if ($round) {

            $this->selected_round = $round;
            $this->round_games  = $this->selected_round->games()->get();
        }
    }

}
