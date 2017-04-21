<?php

namespace CodeFin\Models;

use Carbon\Carbon;

trait BillTrait
{
    public function addDate($dateString, $numMonthOrYear, $repeatType){
        $date = new Carbon($dateString);
        $startDay = $date->day;

        if($repeatType == self::TYPE_MONTHLY){
            $date->addMonths($numMonthOrYear);
        }else{
            $date->addYear($numMonthOrYear);
        }

        if($startDay != $date->day){
            $date->modify('last day of last month');
        }
        return $date;
    }
}