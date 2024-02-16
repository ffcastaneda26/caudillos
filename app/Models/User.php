<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Laravel\Jetstream\HasProfilePhoto;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Cashier\Billable;
use Spatie\Permission\Traits\HasRoles;
use function Illuminate\Events\queueable;
use function PHPUnit\Framework\isNull;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;
    Use Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'change_password',
        'active',
        'phone',
        'adult',
        'accept_terms',
        'paid'
    ];


    public function getFNameAttribute()
    {
        return strtoupper($this->first_name) . ' ' . strtoupper($this->last_name) . ' ' . strtoupper($this->maternal_name);
    }


    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucwords($value);
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucwords($value);
    }

    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ucwords($this->first_name) . ' ' .  ucwords($this->last_name ) . ' ' . ucwords($this->materno),
        );
    }



    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn (mixed $value, array $attributes) => ucwords($this->first_name) . ' ' .  ucwords($this->last_name ) . ' ' . ucwords($this->materno),
        );
    }


    protected function email(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => strtolower($value),
        );
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday'          => 'datetime:Y-m-d',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /*+------------+
      | Relaciones |
      +------------+
     */

    public function picks(): HasMany
    {
        return $this->hasMany(Pick::class);
    }

    public function picks_game($game_id): HasMany
    {
        return $this->hasMany(Pick::class)->where('game_id',$game_id);
    }

    public function pick_game($game_id): HasMany
    {
        return $this->hasMany(Pick::class)->where('game_id',$game_id)->first();
    }

    public function game_pick($game_id){
        return $this->picks()->where('game_id',$game_id)->first();
    }

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }

    public function profile():HasOne
    {
        return $this->hasOne(Profile::class);
    }

    /*+-----------------+
      | Funciones Apoyo |
      +-----------------+
     */

    public function has_position_record_round($round_id){
       return $this->positions->where('round_id',$round_id)->count();
    }

    public function hits_round($round_id){
        return $this->positions->where('round_id',$round_id)->first()->hits;
    }

    public function points_round($round_id){
        return $this->positions->where('round_id',$round_id)->first()->total_points;
    }

    public function read_position_record_round($round_id){
        return $this->positions->where('round_id',$round_id)->first();
    }
    // ¿El usuario tiene pronóstico en el juego?


    public function is_active(){
        return $this->active;
    }

    public function is_adult(){
        return $this->adult;
    }

    // Pronósticos acertados en la jornada
    public function picks_hit_round($round_id){
        $hits = 0;
        foreach($this->picks->where('hit',1) as $pick){
            if($pick->game->round_id == $round_id && $pick->hit){
                $hits++;
            }
        }
        return $hits;
    }

    // ¿Tiene datos complementarios?)
    public function has_suplementary_data(){
        return $this->profile()->count();
    }


    // Sincronizar con STRIPE
    protected static function booted(): void
    {
        static::updated(queueable(function (User $customer) {
            if ($customer->hasStripeId()) {
                $customer->syncStripeCustomerDetails();
            }
        }));
    }

    // Asignarle los pronósticos que falten
    public function create_missing_picks(){

        $games = Game::where('game_day','>=',now())->get();
        foreach($games as $game){
            if($game->allow_pick()){
                $winner = mt_rand(1,2);
                $new_pick = Pick::create([
                    'user_id'   => $this->id,
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

    }

    /*+-------------------+
      | Búsquedas         |
      +-------------------+
    */

    public function scopeGeneral($query,$valor)
    {
        if ( trim($valor) != "") {
            $query->where('first_name','LIKE',"%$valor%")
                 ->orwhere('last_name','LIKE',"%$valor%")
                 ->orwhere('email','LIKE',"%$valor%");
         }
    }

}
