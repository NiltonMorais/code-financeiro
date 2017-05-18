<?php

namespace CodeFin\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindSubscriptionByUserClientCriteria
 * @package namespace CodeFin\Criteria;
 */
class FindSubscriptionByUserClientCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $clientId;

    /**
     * FindSubscriptionByUserClientCriteria constructor.
     * @param $clientId
     */
    public function __construct($clientId)
    {
        $this->clientId = $clientId;
    }

    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        return $model
            ->join('users','users.id','=','subscriptions.user_id')
            ->join('clients','users.client_id','=','clients.id')
            ->where('clients.id','=',$this->clientId);
    }
}
