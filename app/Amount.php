<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amount extends Model
{
    protected $guarded = [];

    public function cards()
    {
        return $this->hasMany('App\Card');
    }
}
