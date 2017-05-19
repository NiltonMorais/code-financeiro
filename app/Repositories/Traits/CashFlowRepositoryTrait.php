<?php
/**
 * Created by PhpStorm.
 * User: Sony Vaio
 * Date: 26/04/2017
 * Time: 00:51
 */

namespace CodeFin\Repositories\Traits;


use Carbon\Carbon;
use CodeFin\Models\BillPay;
use CodeFin\Models\BillReceive;
use CodeFin\Models\CategoryExpense;
use CodeFin\Models\CategoryRevenue;
use Illuminate\Database\MySqlConnection;
use Illuminate\Database\PostgresConnection;
use Illuminate\Support\Facades\DB;

trait CashFlowRepositoryTrait
{
    public function getCashFlowByPeriod(Carbon $dateStart, Carbon $dateEnd)
    {
        $dateFormat = '%Y-%m-%d';
        $dateStartStr = $dateStart->format('Y-m-d');
        $dateEndStr = $dateEnd->format('Y-m-d');

        $revenuesCollection = $this->getQueryCategoriesValuesByPeriod(
            new CategoryRevenue(),
            (new BillReceive())->getTable(),
            $dateStartStr,
            $dateEndStr,
            $dateFormat
        )->get();

        $expensesCollection = $this->getQueryCategoriesValuesByPeriod(
            new CategoryExpense(),
            (new BillPay())->getTable(),
            $dateStartStr,
            $dateEndStr,
            $dateFormat
        )->get();

        return [
            'period_list' => $this->formatPeriods($expensesCollection, $revenuesCollection)
        ];
    }

    public function getCashFlow(Carbon $dateStart, Carbon $dateEnd)
    {
        $datePrevious = $dateStart->copy()->day(1)->subMonths(2);
        $datePrevious->day($datePrevious->daysInMonth);
        $balancePreviousMonth = $this->getBalanceByMonth($datePrevious);

        $revenuesCollection = $this->getCategoriesValuesCollection(
            new CategoryRevenue(),
            (new BillReceive())->getTable(),
            $dateStart,
            $dateEnd
        );

        $expensesCollection = $this->getCategoriesValuesCollection(
            new CategoryExpense(),
            (new BillPay())->getTable(),
            $dateStart,
            $dateEnd
        );

        return $this->formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth);
    }

    public function getBalanceByMonth(Carbon $date)
    {
        $dateString = $date->copy()->day($date->daysInMonth)->format('Y-m-d');
        $modelClass = $this->model();

        $subQuery = (new $modelClass)
            ->toBase()
            ->selectRaw("bank_account_id, MAX(statements.id) as maxid")
            ->whereRaw("statements.created_at <= '$dateString'")
            ->groupBy('bank_account_id');

        $result = (new $modelClass)
            ->selectRaw("SUM(statements.balance) as total")
            ->join(\DB::raw("({$subQuery->toSql()}) as s"), 'statements.id', '=', 's.maxid')
            ->mergeBindings($subQuery)
            ->get();

        return $result->first()->total === null ? 0 : $result->first()->total;
    }

    protected function formatCategories($collection)
    {
        $categories = $collection->unique('name')->pluck('name', 'id')->all();
        $arrayResult = [];

        foreach ($categories as $id => $name) {
            $filtered = $collection->where('id', $id)->where('name', $name);
            $periods = [];
            $filtered->each(function ($category) use (&$periods) {
                $periods[] = [
                    'total' => $category->total,
                    'period' => $category->period,
                ];
            });
            $arrayResult[] = [
                'id' => $id,
                'name' => $name,
                'periods' => $periods,
            ];
        }
        return $arrayResult;
    }

    protected function formatPeriods($expensesCollection, $revenuesCollection)
    {
        $periodExpenseCollection = $expensesCollection->pluck('period');
        $periodRevenueCollection = $revenuesCollection->pluck('period');
        $periodsCollection = $periodExpenseCollection->merge($periodRevenueCollection)->unique()->sort();
        $periodList = [];
        $periodsCollection->each(function ($period) use (&$periodList) {
            $periodList[$period] = [
                'period' => $period,
                'revenues' => ['total' => 0],
                'expenses' => ['total' => 0]
            ];
        });

        foreach ($periodRevenueCollection as $period) {
            $periodList[$period]['revenues']['total'] = $revenuesCollection->where('period', $period)->sum('total');
        }

        foreach ($periodExpenseCollection as $period) {
            $periodList[$period]['expenses']['total'] = $expensesCollection->where('period', $period)->sum('total');
        }

        return array_values($periodList);
    }

    protected function formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth)
    {
        $periodList = $this->formatPeriods($expensesCollection, $revenuesCollection);
        $expensesFormatted = $this->formatCategories($expensesCollection);
        $revenuesFormatted = $this->formatCategories($revenuesCollection);

        $collectionFormatted = [
            'period_list' => $periodList,
            'balance_before_first_month' => $balancePreviousMonth,
            'categories_period' => [
                'expenses' => [
                    'data' => $expensesFormatted
                ],
                'revenues' => [
                    'data' => $revenuesFormatted
                ]
            ]
        ];

        return $collectionFormatted;
    }

    protected function getCategoriesValuesCollection($model, $billTable, Carbon $dateStart, Carbon $dateEnd)
    {
        $dateStartStr = $dateStart->copy()->day(1)->format('Y-m-d');
        $dateEndStr = $dateEnd->copy()->day($dateEnd->daysInMonth)->format('Y-m-d');

        $firstDateStart = $dateStart->copy()->subMonths(1);  // primeiro de janeiro
        $firstDateStartStr = $firstDateStart->format('Y-m-d');

        $firstDateEnd = $firstDateStart->copy()->day($firstDateStart->daysInMonth);  // 31 de janeiro
        $firstDateEndStr = $firstDateEnd->format('Y-m-d');

        $firstCollection = $this->getQueryCategoriesValuesByPeriodAndDone(
            $model,
            $billTable,
            $firstDateEndStr,
            $firstDateEndStr
        )->get();

        $mainCollection = $this->getQueryCategoriesValuesByPeriod(
            $model,
            $billTable,
            $dateStartStr,
            $dateEndStr
        )->get();

        $firstCollection->reverse()->each(function ($value) use ($mainCollection) {
            $mainCollection->prepend($value);
        });

        return $mainCollection;
    }

    protected function getQueryCategoriesValuesByPeriodAndDone($model, $billTable, $dateStart, $dateEnd)
    {
        return $this->getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd)
            ->whereRaw("done = true");
    }

    protected function getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd, $dateFormat = '%Y-%m')
    {
        $table = $model->getTable();
        list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];

        $subQuery = $this->getQueryWithDepth($model);
        $query = $model
            ->addSelect("$table.id")
            ->addSelect("$table.name")
            ->selectRaw("SUM(value) as total")
            ->join("$table as childorself", function ($join) use ($table, $lft, $rgt) {
                $join->on("$table.$lft", '<=', "childorself.$lft")
                    ->whereRaw("$table.$rgt >= childorself.$rgt");
            })
            ->join($billTable, "$billTable.category_id", '=', "childorself.id")
            ->whereBetween('date_due', [$dateStart, $dateEnd])
            ->whereRaw("({$this->getQueryWithDepth($model)->toSql()}) = 0")
            ->groupBy("$table.id", "$table.name", 'period')
            ->orderBy("period")
            ->orderBy("$table.name");

        $query->mergeBindings($subQuery);

        if (DB::connection() instanceof PostgresConnection) {
            $dateFormat = $this->getFormatDateByDatabase($dateFormat);
            $query = $query->selectRaw("TO_CHAR(date_due, '$dateFormat') as period");
        } elseif (DB::connection() instanceof MySqlConnection) {
            $query = $query->selectRaw("DATE_FORMAT(date_due, '$dateFormat') as period");
        }
        return $query;
    }

    protected function getQueryWithDepth($model)
    {
        $table = $model->getTable();

        list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];

        $alias = '_d';

        return $model
            ->newScopedQuery($alias)
            ->toBase()
            ->selectRaw('count(1) - 1')
            ->from("{$table} as {$alias}")
            ->whereRaw("{$table}.{$lft} between {$alias}.{$lft} and {$alias}.{$rgt}");
    }

    protected function getFormatDateByDatabase($mySqlDateFormat)
    {
        $result = $mySqlDateFormat;
        if (DB::connection() instanceof PostgresConnection) {
            $result = str_replace('%', '', $mySqlDateFormat);
            $result = str_replace('Y', 'YYYY', $result);
            $result = str_replace('m', 'MM', $result);
            $result = str_replace('d', 'DD', $result);
        }
        return $result;
    }
}