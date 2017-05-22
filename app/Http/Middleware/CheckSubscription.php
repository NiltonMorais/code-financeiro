<?php

namespace CodeFin\Http\Middleware;

use Carbon\Carbon;
use Closure;
use CodeFin\Criteria\FindSubscriptionByUserClientCriteria;
use CodeFin\Models\Subscription;
use CodeFin\Repositories\Interfaces\SubscriptionRepository;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next, $beforeOrAfter = 'before')
    {

        if ($beforeOrAfter == 'before') {
            if(!$this->hasAuthenticated()){
                return response()->json([
                    'error' => 'invalid_credentials',
                    'message' => 'Email ou senha inválido.'
                ], 403);
            }
            $responseExpired = $this->responseSubscriptionExpired();
            if ($responseExpired) {
                return $responseExpired;
            }
            return $next($request);
        } else {
            $response = $next($request);
            if(!$this->hasAuthenticated()){
                return response()->json([
                    'error' => 'invalid_credentials',
                    'message' => 'Email ou senha inválido.'
                ], 403);
            }
            $responseExpired = $this->responseSubscriptionExpired();
            return !$responseExpired ? $response : $responseExpired;
        }
    }

    protected function responseSubscriptionExpired()
    {
        $subscription = $this->getSubscription();

        if ($subscription) {
            $result = $this->isExpired($subscription);

            if ($result) {
                return response()->json([
                    'error' => 'subscription_expired',
                    'message' => 'Assinatura expirada.'
                ], 403);
            } else {
                return false;
            }
        }

        return response()->json([
            'error' => 'subscription_not_found',
            'message' => 'Cliente sem assinatura contratada.'
        ], 400);
    }

    protected function getSubscription()
    {
        $client = Auth::guard('api')->user()->client;
        $subscription = $this->subscriptionRepository
            ->getByCriteria(new FindSubscriptionByUserClientCriteria($client->id))
            ->first();
        return $subscription;
    }

    protected function isExpired($subscription)
    {
        if (
            !$subscription->expires_at
            || $subscription->status == Subscription::STATUS_INATIVE
            || $subscription->canceled_at != null
        ) {
            return true;
        }

        $expiresAt = new Carbon($subscription->expires_at);
        return $expiresAt->lt(new Carbon()) ? true : false;

    }

    protected function hasAuthenticated()
    {
        return Auth::guard('api')->check() ? true : false;
    }
}
