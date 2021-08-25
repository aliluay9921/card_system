<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $appends = ['cover_image', 'avatar_image'];
    protected $hidden = [
        "created_at", "updated_at",
        "cover", "avatar", "active"
    ];
    protected $fillable = ['name', 'avatar', 'cover', 'active', 'created_at', 'color'];

    public function getCoverImageAttribute()
    {
        return asset('image/companies') . '/' . $this->cover;
    }

    public function getAvatarImageAttribute()
    {
        return asset('image/companies') . '/' . $this->avatar;
    }

    public function transfer()
    {
        return $this->morphMany(Log::class, 'transfer');
    }

}










