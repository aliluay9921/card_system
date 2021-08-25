<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'user_name', 'password', 'phone', 'balance', 'image', 'lat', 'lng', 'city_id', 'email', 'code'
    ];
    protected $appends = ['image_path'];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'image'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */


    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function getImagePathAttribute()
    {
        return asset('image/users/profile') . '/' . $this->image;
    }

    public function transfer()
    {
        return $this->morphMany(Log::class, 'transfer');
    }

    public function routeNotificationForOneSignal()
    {
        return ['include_external_user_ids' => [$this->id]];
    }
}