<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GeneralPosition extends Model
{
    use HasFactory;
    protected $table = 'general_positions';
    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'hits',
        'hits_breaker',
        'total_error',
        'position'
    ];


    /*+-------------+
     | Relaciones   |
     +--------------+
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    /*+-------------+
     | Apoyo   |
     +--------------+
    */

    public function truncate_me(){
        $this::truncate();
    }

    public function create_positions($positions){
        $position = 0;
        foreach($positions as $reg_position){
           $position_general= $this->create([
                'user_id'       => $reg_position->user_id,
                'points'        => $reg_position->total_points,
                'hits'          => $reg_position->hits,
                'hits_breaker'  => $reg_position->hits_breaker,
                'total_error'   => $reg_position->total_error,
                'position'      => ++$position
            ]);
        }
    }

}
