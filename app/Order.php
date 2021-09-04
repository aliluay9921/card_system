<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    protected $appends = ['status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(OrderType::class);
    }

    public function transfer()
    {
        return $this->morphTo();
    }

    public function getStatusAttribute()
    {
        if ($this->admin_id && $this->approved_at) return 'مكتمل';
        return 'قيد الانتظار';
    }
}
