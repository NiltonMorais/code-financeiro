<?php

namespace CodeFin\Models;

use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class Statement extends Model implements Transformable
{
    use TransformableTrait;
    use BelongsToTenants;

    protected $fillable = [
        'value',
        'balance',
        'bank_account_id'
    ];

    public function bankAccount(){
        return $this->belongsTo(BankAccount::class);
    }

    public function statementable()
    {
        return $this->morphTo();
    }

}
