<?php

namespace CodeFin\Http\Controllers\Api;

use CodeFin\Criteria\WithDepthCategoriesCriteria;
use CodeFin\Http\Controllers\Controller;
use CodeFin\Http\Requests;
use CodeFin\Repositories\Interfaces\CategoryExpenseRepository;


class CategoryExpensesController extends Controller
{
    use CategoriesControllerTrait;

    /**
     * @var CategoryExpenseRepository
     */
    protected $repository;


    public function __construct(CategoryExpenseRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithDepthCategoriesCriteria());
    }
}
