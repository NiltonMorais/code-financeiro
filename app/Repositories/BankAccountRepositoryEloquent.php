<?php

namespace CodeFin\Repositories;

use CodeFin\Criteria\LockTableCriteria;
use CodeFin\Events\BankAccountBalanceUpdatedEvent;
use CodeFin\Models\BankAccount;
use CodeFin\Presenters\BankAccountPresenter;
use CodeFin\Repositories\Interfaces\BankAccountRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BankAccountRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
        'agency' => 'like',
        'account' => 'like',
        'bank.name' => 'like'
    ];

    public function addBalance($id, $value)
    {
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        \DB::beginTransaction();
            $this->pushCriteria(new LockTableCriteria());
            $model = $this->find($id);
            $model->balance = $model->balance + $value;
            $model->save();
        \DB::commit();
        broadcast(new BankAccountBalanceUpdatedEvent($model));
        $this->popCriteria(LockTableCriteria::class);

        $this->skipPresenter = $skipPresenter;
        return $this->parserResult($model);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BankAccount::class;
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
        return BankAccountPresenter::class;
    }
}
