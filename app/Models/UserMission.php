<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $missions_id
 * @property integer $users_id
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 * @property Mission $mission
 * @property User $user
 */
class UserMission extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['missions_id', 'users_id', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function mission()
    {
        return $this->belongsTo('App\Models\Mission', 'missions_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }
}
