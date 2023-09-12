<?php

namespace App\Http\Livewire;

use App\Models\Pick;
use App\Models\User;
use App\Models\Round;
use Livewire\Component;
use Illuminate\Contracts\Database\Eloquent\Builder;

class PicksRoundUser extends Component
{
    public $user;
    public $user_picks_round=null;
    public $round;
    public function mount(User $user,Round $round){
        $this->user_picks_round = Pick::select('picks.*')
                                    ->join('games', 'picks.game_id', '=', 'games.id')
                                    ->join('users', 'picks.user_id', '=', 'users.id')
                                    ->where('picks.user_id','=',$user->id)
                                    ->where('games.round_id','=',$round->id)
                                    ->orderBy('games.game_day', 'ASC')
                                    ->orderBy('games.game_time', 'ASC')
                                    ->get();
    }

    public function render()
    {
        return view('livewire.results.picks-round-user');
    }
}
