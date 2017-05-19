<?php

namespace CodeFin\Repositories\Traits;

use Carbon\Carbon;
use CodeFin\Events\BillStoredEvent;
use CodeFin\Serializer\BillSerializer;
use Prettus\Repository\Criteria\RequestCriteria;

trait BillRepositoryTrait
{
    protected function repeatBill(array $attributes)
    {
        $repeat = isset($attributes['repeat']) ? filter_var($attributes['repeat'], FILTER_VALIDATE_BOOLEAN) : false;
        if($repeat){
            $repeatNumber = (int)$attributes['repeat_number'];
            $repeatType = (int)$attributes['repeat_type'];
            $dateDue = $attributes['date_due'];

            foreach(range(1,$repeatNumber) as $value){
                $dateNew = $this->model->addDate($dateDue,$value,$repeatType);
                $attributesNew = array_merge($attributes,['date_due' => $dateNew->format('Y-m-d')]);
                $model = parent::create($attributesNew);
                event(new BillStoredEvent($model));
            }
        }
    }

    public function create(array $attributes)
    {
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model =  parent::create($attributes);
        event(new BillStoredEvent($model));
        $this->repeatBill($attributes);

        $this->skipPresenter = $skipPresenter;
        return $this->parserResult($model);
    }

    public function update(array $attributes, $id)
    {
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $modelOld = $this->find($id);
        $model = parent::update($attributes, $id);
        event(new BillStoredEvent($model,$modelOld));

        $this->skipPresenter = $skipPresenter;
        return $this->parserResult($model);
    }

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter();
        $collection = parent::paginate($limit,$columns,$method);
        $this->skipPresenter($skipPresenter);
        return $this->parserResult(new BillSerializer($collection,$this->formatBillsData()));
    }

    public function getTotalFromPeriod(Carbon $dateStart, Carbon $dateEnd)
    {
        $result = $this->getQueryTotal()
            ->whereBetween('date_due',[$dateStart->format('Y-m-d'),$dateEnd->format('Y-m-d')])
            ->get();
        return [
            'total' => (float)$result->first()->total
        ];
    }

    protected function getTotalByDone($done)
    {
        $result = $this->getQueryTotalByDone($done)->get();
        return (float)$result->first()->total;
    }

    protected function getQueryTotal()
    {
        $this->resetModel();
        $this->popCriteria(RequestCriteria::class);
        $this->applyCriteria();
        return $this->model->selectRaw('SUM(value) as total');
    }

    protected function getQueryTotalByDone($done)
    {
        return $this->getQueryTotal()
            ->where('done','=',$done);
    }

    protected function getTotalExpired()
    {
        $result = $this->getQueryTotalByDone(0)
            ->where('date_due','<',(new Carbon())->format('Y-m-d'))
            ->get();
        return (float)$result->first()->total;
    }

    protected function formatBillsData()
    {
        $totalPaid = $this->getTotalByDone(1);
        $totalToPay = $this->getTotalByDone(0);
        $totalExpired = $this->getTotalExpired();

        return [
            'total_paid' => $totalPaid,
            'total_to_pay' => $totalToPay,
            'total_expired' => $totalExpired,
        ];
    }

}