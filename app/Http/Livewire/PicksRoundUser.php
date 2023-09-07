<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Round;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Livewire\Component;

class PicksRoundUser extends Component
{
    public $user;
    public $user_picks_round=null;
    public $round;
    public function mount(User $user,Round $round){

        $this->user_picks_round = $user->picks()->wherehas('game',function(Builder $query) use ($round) {
            $query->where('round_id',$round->id);
        })->get();

        // dd($this->user_picks_round);

        // $this->user_picks_round  = $round->picks()
        //                         ->where('user_id',$user->id)
        //                         ->orderby('game_id')
        //                         ->get();
        if($round->id != 1){
            dd( $this->user_picks_round );
        }
    }

    public function render()
    {
        return view('livewire.picks-round-user');
    }
}
