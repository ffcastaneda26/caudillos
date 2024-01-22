<?php

namespace App\Http\Livewire;

use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

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

    public function mount()
    {
        $round = new Round();
        $this->current_round = $round->read_current_round();
        $this->selected_round = $this->current_round;
        $this->receive_round($this->selected_round);
        $this->picks_auth_user_round =  $this->selected_round->picks_auth_user()->get();
        $this->read_configuration();
    }

    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */
    public function render(){

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
        return User::role('participante')
                            ->select('users.*')
                            ->Join('picks', 'picks.user_id', '=', 'users.id')
                            ->Join('games', 'picks.game_id', '=', 'games.id')
                            ->where('games.round_id',$this->selected_round->id)
                            ->where('users.active','1')
                            ->where('first_name','LIKE',"%$this->search%")
                            ->orwhere('last_name','LIKE',"%$this->search%")
                            ->orwhere('email','LIKE',"%$this->search%")
                            ->where('users.id','<>',Auth::user()->id)
                            ->groupBy('users.id')
                            ->orderBy('users.first_name')
                            ->orderBy('users.last_name')
                            ->paginate($this->pagination);
            // dd($users);

    }

    /*+------------------------------------+
      | Recibe Jornada y selecciona juegos |
      +------------------------------------+
    */
    public function receive_round(Round $round)
    {

        if ($round) {
            // dd($round);
            $this->selected_round = $round;
            $this->round_games  = $this->selected_round->games()->get();
        }
    }
}
