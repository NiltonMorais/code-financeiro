<?php

namespace CodeFin\Repositories\Interfaces;

use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BillReceiveRepository
 * @package namespace CodeFin\Repositories\Interfaces;
 */
interface BillReceiveRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function getTotalFromPeriod(Carbon $dateStart, Carbon $dateEnd);
}
