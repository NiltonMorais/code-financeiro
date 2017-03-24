<?php

namespace CodeFin\Models;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Bank extends Model implements Transformable
{
    use TransformableTrait;

    const LOGOS_DIR = "banks/images";

    protected $fillable = [
        'name',
        'logo'
    ];

    public function getLogosDirAttribute()
    {
        return self::LOGOS_DIR;
    }

    public function getLogoPathAttribute()
    {
        $logoDir = $this->getLogosDirAttribute();
        $logo = $this->attributes['logo'];
        return "storage/$logoDir/$logo";
    }

}
