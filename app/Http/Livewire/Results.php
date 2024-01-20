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

    public $users_with_picks_round = null;
    public $cols_show = [];

    public function mount()
    {
        $round = new Round();
        $this->search_label = 'Search Participant';
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

        $users = User::whereHas('picks', function ($query)  {
            $query->whereHas('game',function($query){
                $query->where('round_id', $this->selected_round->id)->with('picks');
            });
        })->General($this->search)
             ->paginate();

             dd($users);
        // if($this->search){
        //      dd($users);
        // }

        return view('livewire.results.index', [
            'records' => $users,
        ]);




        // return view('livewire.results.index', [
        //     'records' => User::role('participante')
        //     ->select('users.*')
        //     ->Join('picks', 'picks.user_id', '=', 'users.id')
        //     ->Join('games', 'picks.game_id', '=', 'games.id')
        //     ->where('games.round_id', $this->selected_round->id)
        //     ->where('users.active', '1')
        //     ->groupBy('users.id')
        //     ->paginate($this->pagination),
        // ]);
    }

    /*+------------------------------------+
      | Lee datos                           |
      +------------------------------------+
    */

    private function read_data()
    {
        if($this->search){
            $results =  User::role('participante')
            ->select('users.*')
            ->Join('picks', 'picks.user_id', '=', 'users.id')
            ->Join('games', 'picks.game_id', '=', 'games.id')
            ->where('games.round_id', $this->selected_round->id)
            ->where('users.active', '1')
            ->groupBy('users.id')
            ->paginate($this->pagination);
            if($results->count()){
                foreach ($results as $result){

                    foreach($this->selected_round->picks_user($result->id)->get() as $pick){
                        dd($pick);
                    }
                }
            }
            dd($this->search,$results);
        }
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
