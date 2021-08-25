<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VirtualBalance extends Model
{
    protected $guarded = [];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id', 'id');

    }

    public function user()
    {
        return $this->belongsTo(User::class);

    }
}
