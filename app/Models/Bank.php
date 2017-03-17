<?php

namespace CodeFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Bank extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = [
        'name',
        'logo'
    ];

}
