<?php

namespace CodeFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Subscription extends Model implements Transformable
{
    use TransformableTrait;

    const STATUS_ATIVE = 1;
    const STATUS_INATIVE = 2;

    protected $fillable = [
        'expires_at',
        'canceled_at',
        'code',
        'user_id',
        'plan_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

}
