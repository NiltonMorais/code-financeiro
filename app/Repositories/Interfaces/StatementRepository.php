<?php

namespace CodeFin\Repositories\Interfaces;

use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface StatementRepository
 * @package namespace CodeFin\Repositories\Interfaces;
 */
interface StatementRepository extends RepositoryInterface
{
    public function getCashFlow(Carbon $dateStart, Carbon $dateEnd);
    public function getBalanceByMonth(Carbon $date);
}
