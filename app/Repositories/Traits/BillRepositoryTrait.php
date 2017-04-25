<?php

namespace CodeFin\Repositories\Traits;

use CodeFin\Events\BillStoredEvent;

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

}