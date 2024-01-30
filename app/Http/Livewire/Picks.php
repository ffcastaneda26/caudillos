<?php

namespace App\Http\Livewire;

use App\Models\Game;
use App\Models\Pick;
use App\Models\Round;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\Traits\CrudTrait;
use App\Http\Livewire\Traits\FuncionesGenerales;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Picks extends Component
{
    use AuthorizesRequests;
    use WithPagination;
    use WithFileUploads;
    use CrudTrait;
    use FuncionesGenerales;


    protected $rules = [
        'main_record.user_id'           => 'required|exists:users,id',
        'main_record.game_id'           => 'required|exists:games,id',
        'main_record.winner'            => 'required',
        'main_record.total_points'      => 'nullable',
        'main_record.hit'               => 'nullable',
        'main_record.visit_points'      => 'nullable',
        'main_record.local_points'      => 'nullable',
        'main_record.dif_points_winner' => 'nullable',
        'main_record.dif_points_total'  => 'nullable',
        'main_record.dif_points_local'  => 'nullable',
        'main_record.dif_points_visit'  => 'nullable',
        'main_record.hit_last_game'     => 'nullable',
        'main_record.hit_local'         => 'nullable',
        'main_record.hit_visit'         => 'nullable',
        'main_record.dif_victory'       => 'nullable',
    ];


    protected $listeners = ['receive_round'];

    public $gamesids = array();
    public $picks = array();
    public $message = null;
    public $games_to_pick = array();
    public $old_picks = array();
    public $points_visit_last_game = null;
    public $points_local_last_game = null;
    public $error;

    public $id_game_last_game_roundx = null;
    public $id_game_tie_breaker = null;

    public function mount()
    {
        $this->read_configuration();

        if ($this->configuration->require_payment_to_continue && !Auth::user()->paid) {
            return redirect()->route('dashboard');
        }

        $this->manage_title = 'Pronósticos';
        $this->rounds = $this->read_rounds();
        $round = new Round();
        $this->current_round = $round->read_current_round();
        $this->selected_round = $this->current_round;

        if (Auth::user()->hasRole('participante') && Auth::user()->id != 1) {
            if ($this->configuration->create_mssing_picks) {
                $this->create_missing_picks_to_user($this->current_round->id);
            }
        }
        $this->receive_round($this->current_round);
    }



    /*+---------------------------------+
      | Regresa Vista con Resultados    |
      +---------------------------------+
    */
    public function render()
    {
        // ¿Descansa el equipo de desempate?
        if ($this->configuration->use_team_to_tie_breaker) {
            $this->does_tie_breaker_team_rest = $this->does_tie_breaker_team_rest_in_round($this->selected_round->id);
        }

        return view('livewire.picks.index');
    }

    /*+-----------------------------+
      | Juego para solicitar puntos |
      +-----------------------------+
    */
    private function get_id_game_to_get_points(Round $round)
    {
        $round_games = $round->games()->orderby('game_day')->orderby('game_time')->get();
        foreach ($round_games as $game) {
            if ($game->is_game_tie_breaker()) {
               return $game->id;
            }
        }

        $last_game_round = DB::table('games')
            ->where('round_id', $round->id)
            ->orderBy('game_day', 'desc')
            ->orderBy('game_time', 'desc')
            ->first();
        if($last_game_round){
            return $last_game_round->id;
        }

        return null;


    }

    /*+---------------+
      | Recibe Juegos |
      +---------------+
    */

    public function receive_round(Round $round)
    {
        if ($round) {
            $this->id_game_tie_breaker = $this->get_id_game_to_get_points($round);

            $this->selected_round = $round;
            $this->round_games = $round->games()->orderby('game_day')->orderby('game_time')->get();
            $i = 0;
            $this->reset('gamesids', 'games_to_pick', 'picks', 'points_visit_last_game', 'points_local_last_game', 'error', 'message');


            foreach ($this->round_games as $game) {
                $this->gamesids[$i] = $game->id;
                $pick_user = $game->pick_user();
                if ($pick_user) {
                    $this->picks[$i] = $pick_user->winner;
                    if($pick_user->game_id == $this->id_game_tie_breaker){
                        $this->points_visit_last_game = $pick_user->visit_points;
                        $this->points_local_last_game = $pick_user->local_points;
                    }
                    $i++;
                }
            }
            $i = 0;
            foreach ($this->round_games as $game) {
                if ($game->allow_pick()) {
                    $this->games_to_pick[$i] = $game->id;
                    $i++;
                }
            }
        }
    }

    /*+---------------+
    | Guarda Registro |
    +-----------------+
    */


    public function store()
    {

        if (!$this->validate_data()) return;

        // Actualizamos los pronósticos
        $i = 0;
        foreach ($this->gamesids as $game) {
            $game_pick = Game::findOrFail($game);

            if ($game_pick->allow_pick()) {
                $pick_user = $game_pick->pick_user();
                if ($pick_user) {
                    $pick_user->winner = $this->picks[$i];
                    if ($game_pick->id === $this->id_game_tie_breaker) {
                        $pick_user->local_points = $this->points_local_last_game;
                        $pick_user->visit_points = $this->points_visit_last_game;
                        $pick_user->winner = $pick_user->local_points > $pick_user->visit_points ? 1 : 2;
                    }
                    $pick_user->save();
                } else { // Cuando el juego no tiene pronóstico lo creamos
                    $pick_user = Pick::create([
                        'user_id'   => Auth::user()->id,
                        'game_id'   => $game->id,
                        'winner'    => $this->picks[$i]
                    ]);

                    if ($game->is_last_game_round()) {
                        $pick_user->local_points = $this->points_local_last_game;
                        $pick_user->visit_points = $this->points_visit_last_game;
                        $pick_user->winner       = $pick_user->local_points > $pick_user->visit_points ? 1 : 2;
                    }

                    $pick_user->save();
                }
            }
            $i++;
            $this->show_alert('success', 'Pronósticos Guardados Satisfactoriamente');
        }
    }

    /* Crea el pronóstico */
    private function create_pick($game, $winner)
    {
        $new_pick = Pick::create([
            'user_id'   => Auth::user()->id,
            'game_id'   => $game->id,
            'winner'    => $winner
        ]);

        if ($game->is_last_game_round()) {
            $new_pick->local_points = $this->points_local_last_game;
            $new_pick->visit_points = $this->points_visit_last_game;
            $new_pick->winner       = $new_pick->local_points > $new_pick->visit_points ? 1 : 2;
        }

        $new_pick->save();
    }

    // Validación interna
    private function validate_data()
    {
        $this->reset('message', 'error');

        if (count($this->gamesids) != count($this->picks)) {
            $this->message = "Faltan pronósticos";
            $this->error = 'faltan';
        }

        if (strlen($this->points_visit_last_game) < 1) {
            $this->message = "Debe Introducir Puntos Para Equipo VISITANTE del Partido de Desempate";
            $this->error = 'visit';
            return false;
        }

        if (strlen($this->points_local_last_game) < 1) {
            $this->message = "Debe Introducir Puntos Para Equipo LOCAL del Partido de Desempate";
            $this->error = 'local';
            return false;
        }

        if ($this->points_visit_last_game == $this->points_local_last_game) {
            $this->message = "El últimoo partido no puede ser EMPATE";
            $this->error = 'tie';
            return false;
        }


        if ($this->points_local_last_game > 127) {
            $this->message = "Puntos del Partido de Desempate máximo debe ser 127";
            $this->error = 'local';
            return false;
        }

        if ($this->points_visit_last_game > 127) {
            $this->message = "Puntos del Partido de Desempate máximo debe ser 127";
            $this->error = 'visit';
            return false;
        }
        return true;
    }


    /** Solo para revisar si es necesario */
    public function revisar()
    {
        $this->reset('picks');
        $i = 0;
        foreach ($this->gamesids as $game) {
            $game_pick = Game::findOrFail($game);
            $pick_user = $game_pick->pick_user();
            $this->picks[$i] = $pick_user->winner;
            $i++;
        }

        $revisar = array();
        $i = 0;
        foreach ($this->gamesids as $game) {
            $revisar[$i][0] = $this->picks[$i];
            $revisar[$i][1] = $this->old_picks[$i];
            $i++;
        }
    }
}
