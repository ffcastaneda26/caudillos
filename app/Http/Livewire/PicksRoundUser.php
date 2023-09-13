<?php

namespace App\Http\Livewire;

use App\Models\Pick;
use App\Models\User;
use App\Models\Round;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PicksRoundUser extends Component
{
    public $user;
    // public $user_picks_round=null;
    public $round;
    public $cols_show= [];
    public function mount(User $user,Round $round){

        $this->reset('cols_show');

        // $this->user_picks_round = Pick::select('picks.*')
        //                             ->join('games', 'picks.game_id', '=', 'games.id')
        //                             ->join('users', 'picks.user_id', '=', 'users.id')
        //                             ->where('picks.user_id','=',$user->id)
        //                             ->where('games.round_id','=',$round->id)
        //                             ->orderBy('games.game_day', 'ASC')
        //                             ->orderBy('games.game_time', 'ASC')
        //                             ->get();


            $games  = $round->games()->select('id as game_id')->orderby('id')->get();
            $picks =  Pick::select('picks.game_id')
                    ->distinct('game_id')
                    ->join('games', 'picks.game_id', '=', 'games.id')
                    ->join('users', 'picks.user_id', '=', 'users.id')
                    ->where('picks.user_id','=',$user->id)
                    ->where('games.round_id','=',$round->id)
                    ->get();
            $i=0;

            foreach($games as $game){
                $this->cols_show[$i] = false;
                foreach($picks as $pick){
                    if ($game->game_id == $pick->game_id){
                        $this->cols_show[$i] = $pick->game_id;
                        break;
                    }
                }
                $i++;
            }

    }

    public function render()
    {
        return view('livewire.results.picks-round-user');
    }
}
