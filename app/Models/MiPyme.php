<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property integer $id
 * @property integer $users_id
 * @property string $name
 * @property string $giro
 * @property boolean $is_physical_store
 * @property int $num_employes
 * @property string $rfc
 * @property string $address
 * @property string $created_at
 * @property string $updated_at
 * @property User $user
 */
class MiPyme extends Model
{
    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'mipymes';

    /**
     * @var array
     */
    protected $fillable = ['name', 'giro', 'is_physical_store', 'num_employes', 'rfc', 'address', 'created_at', 'updated_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'users_id');
    }
}
