<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $users_id
 * @property string $first_name
 * @property string $sex
 * @property string $first_last_name
 * @property string $second_last_name
 * @property string $birthdate
 * @property string $photo
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class UserProfile extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'user_profile';

    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['users_id', 'first_name', 'sex', 'first_last_name', 'second_last_name', 'birthdate', 'photo', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }
}
