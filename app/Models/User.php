<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $phone
 * @property string $password
 * @property string $remember_token
 * @property string $email_verified_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Account[] $accounts
 * @property Mipyme[] $mipymes
 * @property UserAddress[] $userAddresses
 * @property UserCard[] $userCards
 * @property UserMission[] $userMissions
 * @property UserProfile[] $userProfiles
 * @property UserRank $userRank
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * @var array
     */
    protected $fillable = ['username', 'email', 'phone', 'password', 'remember_token', 'email_verified_at', 'created_at', 'updated_at', 'deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accounts()
    {
        return $this->hasOne('App\Models\Account', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function mipymes()
    {
        return $this->hasOne('App\Models\Mipyme', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userAddresses()
    {
        return $this->hasOne('App\Models\UserAddress', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userCards()
    {
        return $this->hasMany('App\Models\UserCard', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userMissions()
    {
        return $this->hasMany('App\Models\UserMission', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userProfiles()
    {
        return $this->hasOne('App\Models\UserProfile', 'users_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userRank()
    {
        return $this->hasOne('App\Models\UserRank', 'users_id');
    }
}
