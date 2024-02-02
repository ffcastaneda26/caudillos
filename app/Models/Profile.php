<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;
    protected $table = 'profiles';
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'gender',
        'birthday',
        'curp',
        'entidad_id',
        'municipio_id',
        'codpos',
        'ine_anverso',
        'ine_reverso',
        'stripe_session'
    ];


    // public function setCurpAttribute($value)
    // {
    //     $this->attributes['curp'] = strtoupper($value);
    // }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Setters y Getters


    protected $casts = [
        'birthday'          => 'datetime:Y-m-d',
    ];

}
