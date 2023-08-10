<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    protected $fillable = ['start_date','end_date','type'];


    /*+------------+
       | Relaciones |
       +------------+
     */

    public function games(): HasMany
    {
        return $this->hasMany(Game::class);
    }

    /*+-----------------+
      | Funciones Apoyo |
      +-----------------+
     */

     public function can_be_delete(){
        if($this->games()->count()) return false;

        return true;
    }
    // Jornada actual segun las fechas de inicio y final
     public function  read_current_round(){
        $dt = Carbon::now();

        $current_round = $this::where('start_date','<=',$dt->endOfDay())
                            ->where('end_date','>=',$dt->endOfDay())
                            ->first();
        $current_round->active = 1;
        $current_round->save();
        return $current_round;
     }

     // ¿Es el último partido de la jornada?
     public function is_last_game($game_id){
        return $this->games->last()->id == $game_id;
     }

     // Regresa el último partido de la jornada
     public function get_last_game_round(){
        return $this->games->last();
     }
}
