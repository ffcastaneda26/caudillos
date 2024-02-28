<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Round
 *
 * @property $id
 * @property $start_date
 * @property $end_date
 * @property $type
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Round extends Model
{

    protected $table = 'rounds';
    public $timestamps = false;
    static $rules = [
        'start_date' => 'required',
        'end_date' => 'required',
        'type' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['start_date', 'end_date', 'type'];

    protected $casts = [
        'start_date'    => 'datetime:Y-m-d',
        'end_date'      => 'datetime:Y-m-d',
    ];

    /*+------------+
       | Relaciones |
       +------------+
     */

    public function games(): HasMany
    {
        return $this->hasMany(Game::class)->orderby('game_day')->orderby('game_time');
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    public function picks(): HasManyThrough
    {
        return $this->throughgames()->haspicks();
    }

    public function picks_user($user_id): HasManyThrough
    {
        return $this->throughgames()->haspicks()->where('user_id', $user_id)->orderby('game_day')->orderby('game_time');
    }

    public function picks_auth_user(): HasManyThrough
    {
        return $this->throughgames()->haspicks()->where('user_id', Auth::user()->id)->orderby('game_day')->orderby('game_time');
    }

    /*+-----------------+
      | Funciones Apoyo |
      +-----------------+
     */

    public function can_be_delete()
    {
        if ($this->games()->count()) return false;
        return true;
    }

    // Jornada actual segun las fechas de inicio y final
    public function  read_current_round()
    {
        $sql = "UPDATE rounds SET active=0";
        DB::update($sql);

        $today = now()->toDateString();
        $minDate = Round::min('start_date');
        $current_round = null;
        if ($minDate >= $today) {
            $current_round = Round::where('start_date', $minDate)->first();
        }

        if (!$current_round) {
            $current_round = $this::where('start_date', '<=', $today)
                ->where('end_date', '>=', $today)
                ->first();
            if (!$current_round) {
                $current_round = $this::where('id', $this->max('id'))->first();
            }
        }



        if ($current_round) {

            $current_round->active = 1;
            $current_round->save();
            return $current_round;
        }
        return null;
    }

    // ¿Es el último partido de la jornada?
    public function is_last_game($game_id)
    {
        return $this->games->last()->id == $game_id;
    }

    // Regresa el último partido de la jornada
    public function get_last_game_round()
    {
        return $this->games->last();
    }



    public function get_tie_breaker_game()
    {
        $configuration = Configuration::where('use_team_to_tie_breaker', 1)->first();

        if ($configuration) {
            $teamId = $configuration->team_id;
            $game = $this->games()
                ->where('round_id', $this->id)
                ->where(function ($query) use ($teamId) {
                    $query->where('local_team_id', $teamId)
                        ->orWhere('visit_team_id', $teamId);
                })
                ->orderBy('game_day', 'desc')
                ->orderBy('game_time', 'desc')
                ->first();
        }
        if ($game) {
            return $game;
        }

        return $this->getLatestGame();
    }
    public function getLatestGame()
    {
        return $this->hasMany(Game::class)
            ->orderBy('game_day', 'desc')
            ->orderBy('game_time', 'desc')
            ->first();
    }

    public function has_games_played()
    {
        // Filtra los juegos en la relación que tengan un valor definido en 'local_points' o diferente a null
        return $this->games()->where(function ($query) {
            $query->whereNotNull('local_points');
            $query->orWhere('local_points', '<>', null);
        })->exists();
    }
}
