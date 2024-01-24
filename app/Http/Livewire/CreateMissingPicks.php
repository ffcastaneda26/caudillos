<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use App\Models\Game;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CreateMissingPicks extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;
    use CrudTrait;
    use FuncionesGenerales;

    public $rounds;
    public $users;
    public $games;
    public $count_user;
    public function mount(){
        $this->rounds = Round::all();
        $this->users = User::role('participante')->whereDoesntHave('picks')->get();
        $this->create_my_missing_picks();
    }
    public function render()
    {
        //  dd('Tenemos ' . $this->rounds->count() . ' jornadas y ' . $this->users->count() . ' Usuarios sin pronósticos');

        return view('livewire.create-missing-picks')->layout('layouts.app');
    }

    private function create_my_missing_picks(){
        foreach($this->rounds as $round){
            foreach($this->users as $user){
                    $games = Game::whereDoesntHave('picks', function ($query) use ($user,$round) {
                    $query->where('user_id', $user->id);
                })->where('round_id',  $round->id)
                ->get();

                foreach($games as $game){
                    $this->create_missing_user($round,$game,$user);
                    // dd('Revisar que se hayan generado los pronósticos para el usuario='. $user->id . ' ' . $user->first_name . ' ' . $user->last_name . ' Email=' . $user->email . ' Del Juego No. ' . $game->id);
                }
            }

        }
    }
}
