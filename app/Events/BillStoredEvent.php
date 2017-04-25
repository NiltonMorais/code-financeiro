<?php

namespace CodeFin\Events;

use CodeFin\Models\Bank;
use Illuminate\Http\UploadedFile;

class BillStoredEvent
{
    private $model;

    private $modelOld;

    /**
     * Create a new event instance.
     *
     * @param $model
     * @param $modelOld
     */
    public function __construct($model, $modelOld = null)
    {
        $this->model = $model;
        $this->modelOld = $modelOld;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getModelOld()
    {
        return $this->modelOld;
    }




}
