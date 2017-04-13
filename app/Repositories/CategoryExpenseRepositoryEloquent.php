<?php

namespace CodeFin\Repositories;

use CodeFin\Models\CategoryExpense;
use CodeFin\Repositories\Interfaces\CategoryExpenseRepository;
use CodeFin\Repositories\Traits\CategoryRepositoryTrait;
use CodeFin\Validators\CategoryExpenseValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class CategoryExpenseRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class CategoryExpenseRepositoryEloquent extends BaseRepository implements CategoryExpenseRepository
{
    use CategoryRepositoryTrait;

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return CategoryExpense::class;
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
        return \CodeFin\Presenters\CategoryPresenter::class;
    }
}
