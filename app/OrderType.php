<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderType extends Model
{
    public function transfer()
    {
        return $this->morphMany(Log::class, 'transfer');
    }
}
