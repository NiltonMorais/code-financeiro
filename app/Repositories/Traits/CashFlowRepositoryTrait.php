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

trait CashFlowRepositoryTrait
{
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
            ->join(\DB::raw("({$subQuery->toSql()}) as s"), 'statements.id','=','s.maxid')
            ->mergeBindings($subQuery)
            ->get();

        return $result->first()->total === null ? 0 : $result->first()->total;
    }

    protected function formatCategories($collection)
    {
        $categories = $collection->unique('name')->pluck('name','id')->all();
        $arrayResult = [];

        foreach($categories as $id => $name){
            $filtered = $collection->where('id', $id)->where('name', $name);
            $months_year = [];
            $filtered->each(function($category) use(&$months_year){
                $months_year[] = [
                    'total' => $category->total,
                    'month_year' => $category->month_year,
                ];
            });
            $arrayResult[] = [
                'id'  => $id,
                'name' => $name,
                'months' => $months_year,
            ];
        }
        return $arrayResult;
    }

    protected function formatMonthsYear($expensesCollection, $revenuesCollection)
    {
        $monthsYearExpenseCollection = $expensesCollection->pluck('month_year');
        $monthsYearRevenueCollection = $revenuesCollection->pluck('month_year');
        $monthsYearCollection = $monthsYearExpenseCollection->merge($monthsYearRevenueCollection)->unique()->sort();
        $monthsYearList = [];
        $monthsYearCollection->each(function($monthYear) use(&$monthsYearList){
            $monthsYearList[$monthYear] = [
                'month_year' => $monthYear,
                'revenues' => ['total'=>0],
                'expenses' => ['total'=>0]
            ];
        });

        foreach($monthsYearRevenueCollection as $monthYear){
            $monthsYearList[$monthYear]['revenues']['total'] = $revenuesCollection->where('month_year',$monthYear)->sum('total');
        }

        foreach($monthsYearExpenseCollection as $monthYear){
            $monthsYearList[$monthYear]['expenses']['total'] = $expensesCollection->where('month_year',$monthYear)->sum('total');
        }

        return array_values($monthsYearList);
    }

    protected function formatCashFlow($expensesCollection, $revenuesCollection, $balancePreviousMonth)
    {
        $monthsYearList = $this->formatMonthsYear($expensesCollection, $revenuesCollection);
        $expensesFormatted = $this->formatCategories($expensesCollection);
        $revenuesFormatted = $this->formatCategories($revenuesCollection);

        $collectionFormatted = [
            'months_list' => $monthsYearList,
            'balance_before_first_month' => $balancePreviousMonth,
            'categories_months' => [
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
        $dateEndStr = $dateStart->copy()->day($dateEnd->daysInMonth)->format('Y-m-d');

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

        $firstCollection->reverse()->each(function($value) use($mainCollection){
            $mainCollection->prepend($value);
        });

        return $mainCollection;
    }

    protected function getQueryCategoriesValuesByPeriodAndDone($model, $billTable, $dateStart, $dateEnd)
    {
        return $this->getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd)
            ->where('done',1);
    }

    protected function getQueryCategoriesValuesByPeriod($model, $billTable, $dateStart, $dateEnd)
    {
        $table = $model->getTable();
        list($lft, $rgt) = [$model->getLftName(), $model->getRgtName()];

        return $model
            ->addSelect("$table.id")
            ->addSelect("$table.name")
            ->selectRaw("SUM(value) as total")
            ->selectRaw("DATE_FORMAT(date_due, '%Y-%m') as month_year")
            ->selectSub($this->getQueryWithDepth($model), 'depth')
            ->join("$table as childOrSelf", function($join) use($table, $lft, $rgt){
                $join->on("$table.$lft",'<=',"childOrSelf.$lft")
                    ->whereRaw("$table.$rgt >= childOrSelf.$rgt");
            })
            ->join($billTable, "$billTable.category_id",'=',"childOrSelf.id")
            ->whereBetween('date_due',[$dateStart, $dateEnd])
            ->groupBy("$table.id","$table.name",'month_year')
            ->havingRaw("depth = 0")
            ->orderBy("month_year")
            ->orderBy("$table.name");
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
}