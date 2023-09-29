<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Position extends Model
{
    use HasFactory;

    protected $table = 'positions';


    static $rules = [
        'round_id'          => 'required|exists:rounds,id',
        'user_id'           => 'required|exists:users,id',
		'hits'              => 'nullable',
		'extra_points'      => 'nullable',
		'dif_winner_points' => 'nullable',
		'dif_total_points'  => 'nullable',
		'dif_local_points'  => 'nullable',
		'dif_visit_points'  => 'nullable',
		'dif_victory'       => 'nullable',
		'hit_last_game'     => 'nullable',
		'hit_visit'         => 'nullable',
		'hit_local'         => 'nullable',
		'position'          => 'nullable'
    ];

    protected $perPage = 15;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'round_id',
        'user_id',
        'hits',
        'extra_points',
        'dif_winner_points',
        'dif_total_points',
        'dif_local_points',
        'dif_visit_points',
        'dif_victory',
        'hit_last_game',
        'hit_visit',
        'hit_local',
        'position'
    ];

    /*+------------+
      | Relaciones |
      +------------+
     */

    public function round(): BelongsTo
    {
        return $this->belongsTo(Round::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /*+-----------------+
      | Funciones Apoyo |
      +-----------------+
     */



}
