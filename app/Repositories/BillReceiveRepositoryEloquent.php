<?php

namespace CodeFin\Repositories;

use CodeFin\Models\BillReceive;
use CodeFin\Presenters\BillPresenter;
use CodeFin\Repositories\Interfaces\BillReceiveRepository;
use CodeFin\Repositories\Traits\BillRepositoryTrait;
use CodeFin\Validators\BillReceiveValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BillReceiveRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class BillReceiveRepositoryEloquent extends BaseRepository implements BillReceiveRepository
{
    use BillRepositoryTrait;

    protected $fieldSearchable = [
        'name' => 'like'
    ];

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BillReceive::class;
    }


    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return BillPresenter::class;
    }
}
