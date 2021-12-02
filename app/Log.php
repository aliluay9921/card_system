<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $guarded = [];
    protected $appends = ['timestamp'];

    protected $hidden = ['updated_at'];

    public function card()
    {
        return $this->belongsTo(Card::class, 'key', 'key');
    }


    public function apiCard()
    {
        return $this->belongsTo(Cardapi::class, 'api_card_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function getTimestampAttribute()
    {
        return strtotime($this->created_at);
    }

    public function transfer()
    {
        return $this->morphTo();
    }
}