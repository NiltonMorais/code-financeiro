<?php

namespace CodeFin\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeFin\Repositories\Interfaces\SubscriptionRepository;
use CodeFin\Models\Subscription;
use CodeFin\Validators\SubscriptionValidator;

/**
 * Class SubscriptionRepositoryEloquent
 * @package namespace CodeFin\Repositories;
 */
class SubscriptionRepositoryEloquent extends BaseRepository implements SubscriptionRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subscription::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
