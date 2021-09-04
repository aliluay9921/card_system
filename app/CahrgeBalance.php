<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CahrgeBalance extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function amount()
    {
        return $this->belongsTo(Amount::class, 'amount_id');
    }
}