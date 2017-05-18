<?php

namespace CodeFin\Iugu;


use Carbon\Carbon;
use CodeFin\Criteria\FindByUserCriteria;
use CodeFin\Models\Subscription;
use CodeFin\Repositories\Interfaces\SubscriptionRepository;

class SubscriptionManager
{
    /**
     * @var iuguSubscriptionClient
     */
    private $iuguSubscriptionClient;
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    public function __construct(iuguSubscriptionClient $iuguSubscriptionClient, SubscriptionRepository $subscriptionRepository)
    {
        $this->iuguSubscriptionClient = $iuguSubscriptionClient;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function renew(array $data)
    {
        $iuguSubscription = $this->iuguSubscriptionClient->find($data['id']);
        $subscription = $this->subscriptionRepository->findByField('code', $iuguSubscription->id)->first();
        $result = $subscription;
        if ($subscription && $subscription->expires_at != $iuguSubscription->expires_at) {
            $result = $this->subscriptionRepository->update([
                'expires_at' => $iuguSubscription->expires_at,
                'status' => Subscription::STATUS_ATIVE
            ], $subscription->id);
        }
        return $result;
    }

    public function cancel($subscriptionId)
    {
        $this->subscriptionRepository->pushCriteria(new FindByUserCriteria());
        $subscription = $this->subscriptionRepository->find($subscriptionId);
        $this->iuguSubscriptionClient->suspend($subscription->code);
        $this->subscriptionRepository->update([
            'status' => Subscription::STATUS_INATIVE,
            'canceled_at' => (new Carbon())->format('Y-m-d')
        ],$subscription->id);
    }
}