<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Pick;
use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Results extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;
    use CrudTrait;
    use FuncionesGenerales;

    protected $listeners = ['receive_round'];

    public $gamesids= array();
    public $users_with_picks_round= null;

    public function mount(){
        $this->read_configuration();
        $this->rounds = $this->read_rounds();
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
        return view('livewire.results.index');
    }

    /*+---------------+
      | Recibe Juegos |
      +---------------+
    */

    public function receive_round(Round $round){
        if($round){
            $this->reset('gamesids');
            $this->selected_round = $round;
            $this->gamesids[]   = $round->games()->select('id')->orderby('id')->get()->toArray();
            $this->round_games  = $round->games()->orderby('id')->get();

           $this->users_with_picks_round = User::role('participante')
                            ->wherehas('picks',function(Builder $query) use ($round){
                                $query->wherehas('game',function(Builder $query) use ($round){
                                    $query->where('round_id',$round->id);
                                });
                            })->get();

            // dd( $this->users_with_picks_round);
            // $users = User::role('participante')->whereHas('picks',function(Builder $query){
            //     $query->wherehas('game',function(Builder $query){
            //         $query->where('round_id',$round->id);
            //     })->get();
            // dd($users);
            // $this->round_picks  = $round->picks()
            //                             ->orderby('user_id')
            //                             ->get();

        }
    }


}





