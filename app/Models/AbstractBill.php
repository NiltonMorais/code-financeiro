<?php

namespace CodeFin\Models;

use Carbon\Carbon;
use HipsterJazzbo\Landlord\BelongsToTenants;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

abstract class AbstractBill extends Model implements Transformable, BillRepeatTypeInterface
{
    use TransformableTrait;
    use BelongsToTenants;

    protected $fillable = [
        'date_due',
        'name',
        'value',
        'done',
        'bank_account_id',
        'category_id',
    ];

    protected $casts = [
        'value' => 'float',
        'done' => 'boolean'
    ];

    abstract public function category();

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function statements()
    {
        return $this->morphMany(Statement::class, 'statementable');
    }

    public function addDate($dateString, $numMonthOrYear, $repeatType)
    {
        $date = new Carbon($dateString);
        $startDay = $date->day;

        if ($repeatType == self::TYPE_MONTHLY) {
            $date->addMonths($numMonthOrYear);
        } else {
            $date->addYear($numMonthOrYear);
        }

        if ($startDay != $date->day) {
            $date->modify('last day of last month');
        }
        return $date;
    }
}