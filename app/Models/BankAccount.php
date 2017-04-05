<?php

namespace CodeFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class BankAccount extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'agency',
        'account',
        'default',
        'bank_id',
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

}
