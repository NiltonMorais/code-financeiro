<?php

namespace CodeFin\Http\Controllers\Site;
use CodeFin\Http\Controllers\Controller;
use CodeFin\Repositories\Interfaces\PlanRepository;

class SubscriptionsController extends Controller
{
    /**
     * @var PlanRepository
     */
    private $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function create()
    {
        $plan = $this->planRepository->find(1);
        return view('site.subscriptions.create', compact('plan'));
    }

    public function store()
    {

    }
}