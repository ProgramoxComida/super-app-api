<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property string $name
 * @property string $requirements
 * @property int $points
 * @property string $badge
 * @property UserRank[] $userRanks
 */
class Rank extends Model
{
    /**
     * The "type" of the auto-incrementing ID.
     * 
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['name', 'requirements', 'points', 'badge'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userRanks()
    {
        return $this->hasMany('App\Models\UserRank', 'ranks_id');
    }
}
