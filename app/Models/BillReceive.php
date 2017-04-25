<?php

namespace CodeFin\Models;

class BillReceive extends AbstractBill
{
    public function category()
    {
        return $this->belongsTo(CategoryRevenue::class);
    }
}
