<?php

namespace App\Http\Livewire\Traits;

use App\Models\Game;
use App\Models\Pick;
use App\Models\Team;
use App\Models\User;
use App\Models\Round;
use App\Models\Position;
use App\Models\Configuration;
use App\Models\GeneralPosition;

use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;


trait FuncionesGenerales
{
    public $months_short_spanish = array("Ene","Feb","Mar","Abr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dic");
    public $months_short_english = array("Jab","Feb","Mar","Apr","May","Jun","Jul","Ago","Sep","Oct","Nov","Dec");

    public $id_game_tie_breaker;

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

    public $tie_breaker_game = null;
    public $tie_breaker_game_played = false;
    public $does_tie_breaker_team_rest = false;

    // Valida si debe redireccionar al dashboard

    public function validate_require_payment_to_continue(){

        if (!Auth::user()->hasRole('Admin') && $this->configuration->require_payment_to_continue && !Auth::user()->paid) {
            return redirect()->route('dashboard');
        }
    }

    public function validate_has_sumplentary_data_to_continue(){
        if(!Auth::user()->hasRole('Admin') && !Auth::user()->has_suplementary_data() &&  $this->configuration->require_data_user_to_continue){
            return redirect()->route('data-users');
        }
    }




    // Lee configuración
    public function read_configuration()
    {
        $this->configuration = Configuration::first();
    }

    // Lee Roles
    public function read_roles()
    {
        return $this->roles = Role::orderby('name')->get();
    }

    // Lee jornadas
    public function read_rounds()
    {
        return $this->rounds = Round::orderby('id')->get();
    }

    // Lee jornada seleccionada
    public function select_round(Round $round)
    {
        $this->reset('selected_round');
        if ($round) {
            $this->selected_round = $round;
        } else {
            $this->selected_round = $this->current_round;
        }
        $this->round_games = $this->selected_round->games;
    }


    // Lee equipos
    public function read_teams()
    {
        return $this->teams = Team::orderby('id')->get();
    }


    // Crea pronósticos faltantes del usuario
    public function create_missing_picks_to_user($round_id)
    {
        $games = game::whereDoesntHave('picks', function (Builder $query) {
            $query->where('user_id', Auth::user()->id);
        })->where('round_id', '>=', $round_id)
            ->get();


        foreach ($games as $game) {
            if ($game->allow_pick()) {
                $new_pick_user = $this->create_pick_user_game($game, Auth::user());
            }
        }

        // Si el usuario no tiene registro en tabla POSITIONS lo crea
        if (!Auth::user()->has_position_record_round($round_id)) {
            $this->create_position_record_round_user($round_id);
        }
    }


    public function create_missing_user(Round $round, Game $game, User $user)
    {

        $winner = mt_rand(1, 2);
        $new_pick = Pick::create([
            'user_id'   => $user->id,
            'game_id'   => $game->id,
            'winner'    => $winner
        ]);


        if ($game->is_last_game_round()) {
            if ($winner == 1) {
                $new_pick->local_points = random_int(3, 48);
                $new_pick->visit_points = 0;
            } else {
                $new_pick->local_points = 0;
                $new_pick->visit_points = random_int(3, 48);
            }
            $new_pick->total_points = $new_pick->local_points + $new_pick->visit_points;
        }
        $new_pick->save();

        // Si el usuario no tiene registro en tabla POSITIONS lo crea

        if (!$user->has_position_record_round($round->id)) {
            $this->create_position_record_round_user($round->id);
        }
    }

    // Actualiza los puntos de diferencia a todos los pronósticos del partido
    public function update_pick_game_differences_points(Game $game)
    {
        $game->picks()
            ->update([
                'dif_points_winner' => null,
                'dif_points_local' => null,
                'dif_points_visit' => null,
                'dif_points_total' => null,
                'dif_victory' => null,
                'hit_visit' => 0,
                'hit_local' => 0,
        ]);


        // TODO: Ver si se puede cambiar a ELOQUENT
        $dif_victoria = $game->local_points + $game->visit_points;
        $sql = "UPDATE picks pic,games ga ";
        $sql .= "SET ";
        $sql .= "dif_points_winner= CASE WHEN (" . $game->local_points . ">" . $game->visit_points  . ") THEN abs(pic.local_points - " . $game->local_points . ") ELSE abs(pic.visit_points - " . $game->visit_points  . ")  END,";
        $sql .= "pic.dif_points_local=abs(" . $game->local_points . "-pic.local_points),";
        $sql .= "pic.dif_points_visit= abs(" . $game->visit_points . "-pic.visit_points),";
        $sql .= "pic.dif_points_total= abs(abs(" . $game->visit_points . "-pic.visit_points)+abs(" . $game->local_points . "-pic.local_points)),";
        $sql .= "pic.hit_local= CASE WHEN pic.local_points=" . $game->local_points . " THEN 1 ELSE 0  END,";
        $sql .= "pic.hit_visit= CASE WHEN pic.visit_points=" . $game->visit_points  . " THEN 1 ELSE 0  END,";
        $sql .= "pic.hit= CASE WHEN pic.winner=ga.winner THEN 1 ELSE 0 END,";
        $sql .= "pic.dif_victory=abs(" . $dif_victoria . "-(pic.local_points + pic.visit_points)) ";
        $sql .= "WHERE ga.id = pic.game_id ";
        $sql .= "  AND ga.id=" . $game->id;

        return DB::update($sql);
    }

    // Actualiza Puntos asignados a todos los pronósticos del partido
    public function update_pick_total_points_game(Game $game){
        // Actualiza puntos por haber acertado este partido
        $sql = "UPDATE picks ";
        $sql .= "SET points_by_hit_game=" . $this->configuration->points_to_hit_game . " ";
        $sql .= "WHERE game_id=" . $game->id ;
        $sql .= "   AND hit=1";

        DB::update($sql);

        $game->picks()
            ->update([
                'points_by_local' => DB::raw('CASE
                                                WHEN dif_points_local = 0 THEN 5
                                                WHEN dif_points_local = 1 THEN 4
                                                WHEN dif_points_local = 2 THEN 3
                                                WHEN dif_points_local = 3 THEN 2
                                                ELSE 0
                                            END'),
                'points_by_visit' => DB::raw('CASE
                                                WHEN dif_points_visit = 0 THEN 5
                                                WHEN dif_points_visit = 1 THEN 4
                                                WHEN dif_points_visit = 2 THEN 3
                                                WHEN dif_points_visit = 3 THEN 2
                                                ELSE 0
                                            END'),
                'total_points' => DB::raw('points_by_local + points_by_visit + points_by_hit_game')
            ]);




        // Actualiza puntos por haber acertado partido de desempate
        $sql = "UPDATE picks ";
        $sql .= "SET points_by_hit_tie_breaker_game=" . $this->configuration->points_to_hit_tie_breaker_game . " ";
        $sql .= "WHERE game_id=" . $game->id ;
        $sql .= "   AND hit_last_game=1";
        DB::update($sql);


        // Suma todos los puntos
        $game->picks()->update([
                'total_points' => DB::raw('points_by_local + points_by_visit + points_by_hit_game + points_by_hit_tie_breaker_game'),
            ]);


    }

    // Actualia criterios de desempate
    public function update_tie_breaker(Game $game)
    {

        // Inicializa campos de desempate;
        $sql = "UPDATE positions ";
        $sql .= "SET dif_winner_points=NULL,";
        $sql .= "dif_total_points=NULL,";
        $sql .= "dif_local_points=NULL,";
        $sql .= "dif_visit_points=NULL,";
        $sql .= "dif_victory=NULL,";
        $sql .= "best_shot=NULL,";
        $sql .= "hit_last_game=0,";
        $sql .= "hit_visit=0,";
        $sql .= "hit_local=0,";
        $sql .= "hit_last_game=NULL";

        DB::update($sql);

        // TODO: Actualiza en todos los pronósticos a NULL los criterios de desempate;
        $sql = "UPDATE picks ";
        $sql .= "SET dif_points_local=NULL,";
        $sql .= "dif_points_visit=NULL,";
        $sql .= "dif_points_total=NULL,";
        $sql .= "hit_local=0,";
        $sql .= "hit_visit=0,";
        $sql .= "hit=0,";
        $sql .= "hit_last_game=0,";
        $sql .= "dif_points_winner=NULL,";
        $sql .= "dif_victory=NULL ";
        DB::update($sql);

        // TODO: Calcula criterios de desempate en pronósticos solo para el partido de desempate
        $dif_victoria = $game->local_points + $game->visit_points;
        $sql = "UPDATE picks pic,games ga ";
        $sql .= "SET ";
        $sql .= "pic.dif_points_local=abs(" . $game->local_points . "-pic.local_points),";
        $sql .= "pic.dif_points_visit= abs(" . $game->visit_points . "-pic.visit_points),";
        $sql .= "pic.dif_points_total= abs(abs(" . $game->visit_points . "-pic.visit_points)+abs(" . $game->local_points . "-pic.local_points)),";
        $sql .= "hit_local= CASE WHEN pic.local_points=" . $game->local_points . " THEN 1 ELSE 0  END,";
        $sql .= "hit_visit= CASE WHEN pic.visit_points=" . $game->visit_points  . " THEN 1 ELSE 0  END,";
        $sql .= "hit= CASE WHEN pic.winner=ga.winner THEN 1 ELSE 0 END,";
        $sql .= "hit_last_game= CASE WHEN pic.winner=ga.winner THEN 1 ELSE 0 END,";
        $sql .= "dif_points_winner= CASE WHEN (" . $game->local_points . ">" . $game->visit_points  . ") THEN abs(pic.local_points - " . $game->local_points . ") ELSE abs(pic.visit_points - " . $game->visit_points  . ")  END,";
        $sql .= "pic.dif_victory=abs(" . $dif_victoria . "-(pic.local_points + pic.visit_points)) ";
        $sql .= "WHERE ga.id = pic.game_id ";
        $sql .= "  AND ga.id=" . $game->id;
        return DB::update($sql);
    }

    // Actualiza si acertó el último partido
    public function update_hit_last_game(Game $game)
    {
        // TODO: Cambiar el atributo hit_last_game por hit_tie_breaker_game
        $sql = "UPDATE picks pic,games ga ";
        $sql .= "SET hit_last_game= CASE WHEN pic.winner=ga.winner THEN 1 ELSE 0 END ";
        $sql .= "WHERE ga.id = pic.game_id ";
        $sql .= "  AND ga.visit_points IS NOT NULL ";
        $sql .= "  AND ga.local_points IS NOT NULL ";
        $sql .= "  AND ga.id=" . $game->id;
        return DB::update($sql);
    }
    // // Califica los pronósticos
    public function qualify_picks()
    {
        Pick::join('games', 'games.id', '=', 'picks.game_id')
            ->update([
                'picks.hit' => DB::raw('CASE WHEN picks.winner = games.winner THEN 1 ELSE 0 END')
            ]);

    }

    // Crea el registro en tabla POSITIONS recibiendo ronda y usuario si este es null asume usuario conectado
    public function create_position_record_round_user($round_id, $user_id = null)
    {
        if (!$user_id) {
            $user_id = Auth::user()->id;
        }
        $new_position_record = new Position();
        $new_position_record->round_id = $round_id;
        $new_position_record->user_id = $user_id;
        $new_position_record->save();
        return  $new_position_record;
    }

    // Crea puntos x jornada
    public function update_total_hits_positions(Round $round, Game $game = null)
    {

        $picks_to_positions = User::role('participante')
            ->select(
                'users.id as user_id',
                DB::raw('SUM(picks.hit) as hits'),
                DB::raw('SUM(picks.dif_points_total) as dif_total_points'),
                DB::raw('SUM(picks.dif_points_local) as dif_local_points'),
                DB::raw('SUM(picks.dif_points_visit) as dif_visit_points'),
                DB::raw('SUM(picks.dif_points_winner) as dif_winner_points'),
                DB::raw('SUM(picks.dif_victory) as dif_victory'),
                DB::raw('SUM(picks.hit_last_game) as hit_last_game'),
                DB::raw('SUM(picks.hit_local) as hit_local'),
                DB::raw('SUM(picks.hit_visit) as hit_visit'),
                DB::raw('SUM(picks.points_by_local) as points_by_local'),
                DB::raw('SUM(picks.points_by_visit) as points_by_visit'),
                DB::raw('SUM(picks.points_by_hit_tie_breaker_game) as points_by_hit_tie_breaker_game'),
                DB::raw('SUM(picks.points_by_hit_game) as points_by_hit_game'),
                DB::raw('SUM(picks.total_points) as total_points'),
            )
            ->Join('picks', 'picks.user_id', '=', 'users.id')
            ->Join('games', 'picks.game_id', '=', 'games.id')
            ->where('games.round_id', $round->id)
            ->where('users.active', '1')
            ->groupBy('users.id')
            ->get();



        if (!empty($picks_to_positions)) {
            foreach ($picks_to_positions as $pick_to_position) {

                $user = User::findOrFail($pick_to_position->user_id);
                if (!$user->has_position_record_round($round->id)) {
                    $position_record =  $this->create_position_record_round_user($round->id, $user->id);
                }
                $position_record = Position::where('user_id', $user->id)
                    ->where('round_id', $round->id)
                    ->first();

                $position_record->hits = $pick_to_position->hits;
                $position_record->dif_winner_points = $pick_to_position->dif_winner_points;
                $position_record->dif_total_points  = $pick_to_position->dif_total_points;
                $position_record->dif_local_points  = $pick_to_position->dif_local_points;
                $position_record->dif_visit_points  = $pick_to_position->dif_visit_points;
                $position_record->dif_victory       = $pick_to_position->dif_victory;
                $position_record->hit_last_game     = $pick_to_position->hit_last_game;
                $position_record->hit_visit         = $pick_to_position->hit_visit;
                $position_record->hit_local         = $pick_to_position->hit_local;
                $position_record->best_shot         = $pick_to_position->dif_local_points > $pick_to_position->dif_visit_points
                                                            ? $pick_to_position->dif_visit_points
                                                            : $pick_to_position->dif_local_points;

                $position_record->points_by_local   = $pick_to_position->points_by_local;
                $position_record->points_by_visit   = $pick_to_position->points_by_visit;
                $position_record->points_by_hit_game= $pick_to_position->points_by_hit_game;
                $position_record->total_points      = $pick_to_position->total_points;
                $position_record->points_by_hit_tie_breaker_game   = $pick_to_position->points_by_hit_tie_breaker_game;

                // TODO:: Revisar si es el partido de desempate
                    if ($game && $game->is_last_game_round()) {
                        $pick_user_game =  $user->picks_game($game->id)->first();
                        $position_record->tie_break_visit_points = $pick_user_game->visit_points;
                        $position_record->tie_break_local_points = $pick_user_game->local_points;
                        $position_record->tie_break_winner       = $pick_user_game->winner;
                    }

                $position_record->save();
            }
        }
    }

    // Asigna posición a tabla de POSITIONS

    public function update_positions()
    {
        $this->update_positions_to_null();

        $positions = Position::orderbyDesc('total_points')
            ->orderbyDesc('hits')
            ->orderby('dif_total_points')
            ->orderby('dif_local_points')
            ->orderby('dif_visit_points')
            ->orderbyDesc('hit_last_game')
            ->orderby('best_shot')
            ->orderby('dif_winner_points')
            ->orderby('dif_victory')
            ->orderby('created_at')
            ->get();

        $i = 1;
        foreach ($positions as $position) {
            $position->position = $i++;
            $position->save();
        }
    }

    // Actualiza posiciones a NULL
    public function update_positions_to_null()
    {
        $sql = "UPDATE positions ";
        $sql .= "SET position=NULL ";
        DB::update($sql);
    }


    /**+--------------------------------------------------------+
       |  Lee tabla de POSICIONES x Cada Participante           |
       +--------------------------------------------------------+
       |                Suma                    |  Ordenado x   |
       +----------------------------------------+---------------+
       | - Aciertos                             | Descendente   |
       | - Veces que ha acertado último partido | Descendente   |
       | - Dferencia total de puntos            | Ascendente    |
       +--------------------------------------------------------+
     */

    public function read_general_positions()
    {
        $positions = User::role('participante')
            ->select(
                'users.id as user_id',
                DB::raw('SUM(positions.total_points) as total_points'),
                DB::raw('SUM(positions.hits) as hits'),
                DB::raw('SUM(positions.hit_last_game)    as hits_breaker'),
                DB::raw('SUM(positions.dif_total_points) as total_error')
            )
            ->Join('positions', 'positions.user_id', '=', 'users.id')
            ->where('users.active', '1')
            ->groupBy('users.id')
            ->orderbyDesc('total_points')
            ->orderbyDesc('hits')
            ->orderbyDesc('hits_breaker')
            ->orderby('total_error')
            ->get();

        return $positions;
    }

    public function tie_breaker_game_has_played()
    {
        $configuration_record = Configuration::first();
        if ($configuration_record->use_team_to_tie_breaker && $configuration_record->team_id) {

            $this->tie_breaker_game = Game::Where('round_id', $this->selected_round->id)
                ->where('local_team_id', $configuration_record->team_id)
                ->orwhere('visit_team_id', $configuration_record->team_id)
                ->first();
            $this->tie_breaker_game_played = $this->tie_breaker_game->has_result();
        } else {
            $this->tie_breaker_game = null;
            $this->tie_breaker_game_played = false;
        }
    }

    // ¿Descansa el equipo de desempate?
    public function does_tie_breaker_team_rest_in_round($round_id)
    {

        $game = Game::where('round_id', $round_id)
            ->where(function ($query) {
                $query->where('local_team_id', $this->configuration->team_id)
                    ->orWhere('visit_team_id', $this->configuration->team_id);
            })->first();
        if ($game) {
            return false;
        }

        return true;
    }

    public function get_id_game_to_get_points(Round $round)
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
        if ($last_game_round) {
            return $last_game_round->id;
        }

        return null;
    }

    public function create_pick_user_game(Game $game, User $user)
    {
        $winner = mt_rand(1, 2);

        $new_pick = Pick::create([
            'user_id'   => $user->id,
            'game_id'   => $game->id,
            'winner'    => $winner
        ]);


        // TODO: Aplicar puntos mínimo y máximos configurados
        // $loser_points = random_int($this->configuration->points_min_to_create_picks,$this->configuration->points_min_to_create_picks);
        // $winner_points = random_int($this->configuration->points_min_to_create_picks,$this->configuration->points_max_to_create_picks);

        $loser_points = 0;
        $winner_points = 2;

        if ($this->configuration->require_points_in_picks) {
            $new_pick->local_points = $winner == 1  ? $winner_points : $loser_points;
            $new_pick->visit_points = $winner == 2  ? $winner_points : $loser_points;
        } else {
            if ($this->id_game_tie_breaker) {
                $new_pick->local_points = $winner == 1  ? $winner_points : $loser_points;
                $new_pick->visit_points = $winner == 2  ? $winner_points : $loser_points;
            }
        }
        $new_pick->save();
        return $new_pick;
    }

    public function update_picks_and_positions(Game $game){

        $this->qualify_picks();                                    // Califica pronósticos
        // TODO: Revisar ¿Por qué se está haciendo esta validación y por qué no $game-> is_game_tie_breaker()
        if($this->id_game_tie_breaker == $this->main_record->id){
            $this->update_hit_last_game($this->main_record);        // ¿Acertó último partido?
        }

        if($this->configuration->require_points_in_picks){
            $this->update_pick_game_differences_points($this->main_record); // Diferencia en puntos anotados
            $this->update_pick_total_points_game($this->main_record);       // Asigna Puntos para desempate
        }else{
            if($this->id_game_tie_breaker == $this->main_record->id){
                $this->update_tie_breaker($this->main_record);  // Criterios de desempate
            }
        }

        /*+-------------------------------------------------------------------------+
          |     VALORES PARA LAS POSICIONES TANTO EN JORNADA COMO TABLA GENERAL     |
          +-------------------------------------------------------------------------+
          | 1.- Si usuario no tiene registro en tabla posiciones x jornada crearlo  |
          | 2.- Actualizar valores en tabla de posiciones x Jornada                 |
          | 3.- Asignar posición en tabla de posiciones x Jornada                   |
          | 4.- Asignar posición en tabla de posiciones General                     |
          +-------------------------------------------------------------------------+
         */

        $this->update_total_hits_positions( $this->selected_round,$this->main_record); // Actualiza tabla de aciertos por jornada (POSITIONS)

        $this->update_positions();                                  // Asigna posiciones en tabla de POSITIONS
        $general_position = new GeneralPosition();
        $positions = $this->read_general_positions();                // Lee posicions generales
        if($positions){
            $general_position->truncate_me();
            $general_position->create_positions($positions);
        }
    }
}
