<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class AccountHistory
 * @package App\Models
 * @version October 12, 2018, 2:23 pm UTC
 *
 * @property integer account_id
 * @property integer user_id
 * @property string message
 */
class AccountHistory extends Model
{
    use SoftDeletes;

    public $table = 'account_histories';
    
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'account_id',
        'user_id',
        'message'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'account_id' => 'integer',
        'user_id' => 'integer',
        'message' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    //Get the user's account histories

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
    
}
