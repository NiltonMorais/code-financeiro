<?php

namespace CodeFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Repositories\Interfaces\BankRepository;
use CodeFin\Models\Bank;
use CodeFin\Validators\BankValidator;

/**
 * Class BankRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class BankRepositoryEloquent extends BaseRepository implements BankRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bank::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
