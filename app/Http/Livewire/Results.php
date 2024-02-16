<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
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
    public $sort_secondary = 'last_name';
    public $sort_by = 'hits';
    public $order_by = 'hits_desc';
    public $tie_breaker_game;
    public $tie_breaker_game_allow_pick = false;
    public $tie_breaker_game_has_result = false;
    public $round_has_games_played = false;

    public function mount()
    {
        $this->read_configuration();
        $this->validate_require_payment_to_continue();
        $this->validate_has_sumplentary_data_to_continue();
        $round = new Round();
        $this->current_round = $round->read_current_round();
        $this->selected_round = $this->current_round;
        $this->receive_round($this->selected_round);
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */
    public function render()
    {

        return view('livewire.results.index', ['records' => $this->read_data()]);
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
                $this->sort = 'name';
                $this->direction = 'desc';
                break;
        }

        if($this->sort == 'name'){
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
        }else{
            $users = User::role('participante')
            ->join('positions', 'users.id', '=', 'positions.user_id')
            ->join('rounds', 'positions.round_id', '=', 'rounds.id')
            ->where('rounds.id', '=', $this->selected_round->id)
            ->where('users.active', '1')
            ->where('first_name', 'LIKE', "%$this->search%")
            ->orwhere('last_name', 'LIKE', "%$this->search%")
            ->orwhere('email', 'LIKE', "%$this->search%")
            ->groupBy('users.id',
                      'positions.position',
                      'positions.total_points',
                      'positions.hits')
            ->select('users.*',
                     DB::raw('CONCAT(users.first_name, " ", users.last_name) as name'),
                     'positions.total_points',
                     'positions.position',
                     'positions.hits')
            ->orderby('positions.total_points', $this->direction);

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
            $this->tie_breaker_game = $this->selected_round->get_tie_breaker_game();
            $this->round_has_games_played = $this->selected_round->has_games_played();
            $this->tie_breaker_game_allow_pick=$this->tie_breaker_game->allow_pick();
            $this->tie_breaker_game_has_result=$this->tie_breaker_game->has_result();
            $this->id_game_tie_breaker = $this->tie_breaker_game->id;
            $this->round_games  = $this->selected_round->games()->get();
        }
    }

}
