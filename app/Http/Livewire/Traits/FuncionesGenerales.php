<?php

namespace App\Http\Livewire\Traits;

use App\Models\Game;
use App\Models\Pick;
use App\Models\Team;
use App\Models\User;
use App\Models\Round;
use App\Models\Position;
use App\Models\Configuration;
use Illuminate\Support\Facades\DB;

use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;


trait FuncionesGenerales
{
    // Variables
    public $selected_round  = null;
    public $round_games     = null;
    public $current_round   = null;
    public $rounds          = null;
    public $roles           = null;
    public $teams           = null;
    public $team            = null;
    public $round_id        = null;
    public $role_id        = null;

    public $team_id         = null;
    public $game_instance   = null;
    public $configuration   = null;
    public $round_positions = null;
    public $round_picks     = null;



    // Lee configuración
    public function read_configuration(){
        $this->configuration = Configuration::first();

    }

    // Lee Roles
    public function read_roles(){
        return $this->roles = Role::orderby('name')->get();
    }

    // Lee jornadas
    public function read_rounds(){
        return $this->rounds = Round::orderby('id')->get();
    }

    // Lee jornada seleccionada
    public function select_round(Round $round){
        $this->reset('selected_round');
        if($round){
            $this->selected_round = $round;
        }else{
            $this->selected_round = $this->current_round;
        }
        $this->round_games = $this->selected_round->games;
    }


    // Lee equipos
    public function read_teams(){
        return $this->teams = Team::orderby('id')->get();
    }


    // Crea pronósticos faltantes del usuario
    public function create_missing_picks_to_user($round_id){
        $games = game::whereDoesntHave('picks', function (Builder $query) {
            $query->where('user_id',Auth::user()->id);
            })->where('round_id','>=',$round_id)
              ->get();


        foreach($games as $game){
            if($game->allow_pick()){
                $winner = mt_rand(1,2);
                $new_pick = Pick::create([
                    'user_id'   => Auth::user()->id,
                    'game_id'   => $game->id,
                    'winner'    => $winner
                    ]);

                if($game->is_last_game_round()){
                    if($winner == 1){
                        $new_pick->local_points = 7;
                        $new_pick->visit_points = 0;
                    }else{
                        $new_pick->local_points = 0;
                        $new_pick->visit_points = 7;
                    }
                    $new_pick->total_points = 7;
                }
                $new_pick->save();

            }
        }

        // Si el usuario no tiene registro en tabla POSITIONS lo crea

        if(!Auth::user()->has_position_record_round($round_id)){

            $this->create_position_record_round_user($round_id);
        }

    }


    // Actualia criterios de desempate
    public function update_tie_breaker(Game $game){

        // Inicializa campos de desempate;
        $sql = "UPDATE positions ";
		$sql.="SET dif_winner_points=NULL,";
        $sql.="dif_total_points=NULL,";
        $sql.="dif_local_points=NULL,";
        $sql.="dif_visit_points=NULL,";
        $sql.="dif_victory=NULL,";
        $sql.="best_shot=NULL,";
        $sql.="hit_last_game=0,";
        $sql.="hit_visit=0,";
        $sql.="hit_local=0,";
        $sql.="hit_last_game=NULL";

        DB::update($sql);

        $sql = "UPDATE picks ";
		$sql.="SET dif_points_local=NULL,";
        $sql.="dif_points_visit=NULL,";
        $sql.="dif_points_total=NULL,";
        $sql.="hit_local=0,";
        $sql.="hit_visit=0,";
        $sql.="hit=0,";
        $sql.="hit_last_game=0,";
        $sql.="dif_points_winner=NULL,";
        $sql.="dif_victory=NULL ";
        DB::update($sql);

        $dif_victoria = $game->local_points + $game->visit_points ;
        $sql = "UPDATE picks pic,games ga ";
		$sql.="SET ";
		$sql.="pic.dif_points_local=abs(".$game->local_points."-pic.local_points),";
		$sql.="pic.dif_points_visit= abs(".$game->visit_points ."-pic.visit_points),";
		$sql.="pic.dif_points_total= abs(abs(". $game->visit_points . "-pic.visit_points)+abs(". $game->local_points."-pic.local_points)),";
		$sql.="hit_local= CASE WHEN pic.local_points=". $game->local_points . " THEN 1 ELSE 0  END,";
		$sql.="hit_visit= CASE WHEN pic.visit_points=". $game->visit_points  ." THEN 1 ELSE 0  END,";
		$sql.="hit= CASE WHEN pic.winner=ga.winner THEN 1 ELSE 0 END,";
        $sql.="hit_last_game= CASE WHEN pic.winner=ga.winner THEN 1 ELSE 0 END,";
		$sql.="dif_points_winner= CASE WHEN (" . $game->local_points . ">". $game->visit_points  . ") THEN abs(pic.local_points - " . $game->local_points . ") ELSE abs(pic.visit_points - " . $game->visit_points  . ")  END,";
		$sql.="pic.dif_victory=abs(" . $dif_victoria . "-(pic.local_points + pic.visit_points)) ";
		$sql.="WHERE ga.id = pic.game_id ";
		$sql.="  AND ga.id=" . $game->id;
        return DB::update($sql);
    }

    // Actualiza si acertó el último partido
    public function update_hit_last_game(Game $game){
        $sql = "UPDATE picks pic,games ga ";

        $sql.="WHERE ga.id = pic.game_id ";
		$sql.="  AND ga.id=" . $game->id;
        return DB::update($sql);
    }
    // // Califica los pronósticos
    public function qualify_picks(Game $game){
        $sql = "UPDATE picks pic,games ga ";
		$sql.="SET ";
		$sql.="hit= CASE WHEN pic.winner=ga.winner THEN 1 ELSE 0 END ";
		$sql.="WHERE ga.id = pic.game_id ";
        DB::update($sql);
    }

    // Crea el registro en tabla POSITIONS recibiendo ronda y usuario si este es null asume usuario conectado
    public function create_position_record_round_user($round_id,$user_id=null){
        if(!$user_id){
            $user_id = Auth::user()->id;
        }
        $new_position_record = new Position();
        $new_position_record->round_id = $round_id;
        $new_position_record->user_id = $user_id;
        $new_position_record->save();
        return  $new_position_record;

    }

    // Crea puntos x jornada
    public function update_total_hits_positions(Round $round){

        $hits = User::role('participante')
                    ->select('users.id as user_id',
                                DB::raw('SUM(picks.hit) as hits'),
                                DB::raw('SUM(picks.dif_points_total) as dif_total_points'),
                                DB::raw('SUM(picks.dif_points_local) as dif_local_points'),
                                DB::raw('SUM(picks.dif_points_visit) as dif_visit_points'),
                                DB::raw('SUM(picks.dif_points_winner) as dif_winner_points'),
                                DB::raw('SUM(picks.dif_victory) as dif_victory'),
                                DB::raw('SUM(picks.hit_last_game) as hit_last_game'),
                                DB::raw('SUM(picks.hit_local) as hit_local'),
                                DB::raw('SUM(picks.hit_visit) as hit_visit'),)
                    ->Join('picks', 'picks.user_id', '=', 'users.id')
                    ->Join('games', 'picks.game_id', '=', 'games.id')
                    ->where('games.round_id',$round->id)
                    ->where('users.active','1')
                    ->groupBy('users.id')
                    ->get();


        if(!empty($hits)){
            foreach($hits as $hit){

                $user = User::findOrFail($hit->user_id);
                if(!$user->has_position_record_round($round->id)){
                   $position_record =  $this->create_position_record_round_user($round->id,$user->id);
                }
                $position_record = Position::where('user_id',$user->id)
                                            ->where('round_id',$round->id)
                                            ->first();

                $position_record->hits = $hit->hits;
                $position_record->dif_winner_points = $hit->dif_winner_points;
                $position_record->dif_total_points  = $hit->dif_total_points;
                $position_record->dif_local_points  = $hit->dif_local_points;
                $position_record->dif_visit_points  = $hit->dif_visit_points;
                $position_record->dif_victory       = $hit->dif_victory;
                $position_record->hit_last_game     = $hit->hit_last_game;
                $position_record->hit_visit         = $hit->hit_visit;
                $position_record->hit_local         = $hit->hit_local;
                $position_record->best_shot         = $hit->dif_local_points > $hit->dif_visit_points ? $hit->dif_visit_points
                                                                                                      : $hit->dif_local_points;
                $position_record->save();
            }
        }



    }

    // Asigna posición a tabla de POSITIONS

    public function update_positions(){
        $this->update_positions_to_null();

        $positions = Position::orderbyDesc('hits')
                            ->orderby('dif_total_points')
                            ->orderby('best_shot')
                            ->orderby('dif_winner_points')
                            ->orderby('dif_local_points')
                            ->orderbyDesc('hit_last_game')
                            ->orderby('dif_victory')
                            ->orderby('created_at')
                            ->get();

        $i=1;
        foreach($positions as $position){
            $position->position = $i++;
            $position->save();
        }

    }

    // Actualiza posiciones a NULL
    public function update_positions_to_null(){
        $sql = "UPDATE positions ";
		$sql.="SET position=NULL ";
        DB::update($sql);
    }

    // Lee y calcula para poner la tabla General de Posiciones

    public function read_records_to_general_positions(){
        $positions = User::role('participante')
                        ->select('users.first_name as first_name',
                                'users.last_name as last_name',
                                DB::raw('SUM(positions.hits) as hits'),
                                DB::raw('SUM(positions.hit_last_game)    as hit_last_games'),
                                DB::raw('SUM(positions.dif_total_points) as dif_total_points'))
            ->Join('positions', 'positions.user_id', '=', 'users.id')
            ->where('users.active','1')
            ->groupBy('users.id')
            ->orderbyDesc('hits')
            ->orderbyDesc('hit_last_games')
            ->orderby('dif_total_points')
            ->paginate(15);

        return $positions;
    }
}
