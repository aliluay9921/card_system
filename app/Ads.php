<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ads extends Model
{
    protected $appends = ['image_path'];
    protected $guarded = [];
    protected $hidden = ['image', 'active', 'public'];

    public function getImagePathAttribute()
    {
        return asset('image/ads') . '/' . $this->image;
    }

    public function user()
    {
        return $this->belongsTo(Ads_user::class, 'id', 'ads_id');
    }

    public function users()
    {
        return $this->belongsToMany(
            User::class,
            'ads_users')->withTimestamps();
    }
}


