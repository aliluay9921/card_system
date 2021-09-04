<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    protected $fillable = ['name', 'name_ar', 'phone_number', 'active'];
    public function transfer()
    {
        return $this->morphMany(Log::class, 'transfer');
    }
}