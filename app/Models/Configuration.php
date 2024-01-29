<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Configuration extends Model
{

    protected $table = 'configuration';
    public $timestamps = false;
    static $rules = [
		'website_name'                  => 'required',
		'website_url'                   => 'required',
		'email'                         => 'required',
		'score_picks'                   => 'nullable',
		'minuts_before_picks'           => 'required',
		'allow_tie'                     => 'nullable',
        'create_mssing_picks'           => 'nullable',
        'require_payment_to_continue'   => 'nullable',
        'require_data_user_to_continue' => 'nullable',
        'assig_role_to_user'            => 'nullable',
        'add_user_to_stripe'            => 'nullable',
        'use_team_to_tie_breaker'       => 'nullable',
        'team_id'                       => 'nullable'
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
            'website_name',
            'website_url',
            'email',
            'score_picks',
            'minuts_before_picks',
            'allow_tie',
            'create_mssing_picks',
            'require_payment_to_continue',
            'require_data_user_to_continue',
            'assig_role_to_user',
            'add_user_to_stripe',
            'use_team_to_tie_breaker',
            'team_id'

    ];

    /*+------------+
       | Relaciones |
       +------------+
    */
    public function TeamTieBreaker():BelongsTo
    {
        return $this->belongsTo(Team::class,'team_id');
    }

    /*+-----------------+
      | Funciones Apoyo |
      +-----------------+
     */

     public function can_be_delete(){
        return false;
    }


}
