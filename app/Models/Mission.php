<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $mission
 * @property string $description
 * @property string $icon
 * @property boolean $status
 * @property string $created_at
 * @property string $updated_at
 * @property UserMission[] $userMissions
 */
class Mission extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['mission', 'description', 'icon', 'status', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userMissions()
    {
        return $this->hasMany('App\Models\UserMission', 'missions_id');
    }
}
