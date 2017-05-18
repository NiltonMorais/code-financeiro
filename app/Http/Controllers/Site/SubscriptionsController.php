<?php

namespace CodeFin\Http\Controllers\Site;

use CodeFin\Http\Controllers\Controller;
use CodeFin\Http\Requests\SubscriptionCreateRequest;
use CodeFin\Iugu\Exceptions\AbstractIuguException;
use CodeFin\Iugu\Exceptions\IuguCustomerException;
use CodeFin\Iugu\Exceptions\IuguPaymentMethodException;
use CodeFin\Iugu\Exceptions\IuguSubscriptionException;
use CodeFin\Iugu\IuguSubscriptionManager;
use CodeFin\Repositories\Interfaces\PlanRepository;
use Illuminate\Support\Facades\Auth;

class SubscriptionsController extends Controller
{
    /**
     * @var PlanRepository
     */
    private $planRepository;
    /**
     * @var IuguSubscriptionManager
     */
    private $iuguSubscriptionManager;

    public function __construct(PlanRepository $planRepository, IuguSubscriptionManager $iuguSubscriptionManager)
    {
        $this->planRepository = $planRepository;
        $this->iuguSubscriptionManager = $iuguSubscriptionManager;
    }

    public function create()
    {
        $plan = $this->planRepository->all()->first();
        return view('site.subscriptions.create', compact('plan'));
    }

    public function store(SubscriptionCreateRequest $request)
    {
        $plan = $this->planRepository->all()->first();

        try {
            $this->iuguSubscriptionManager->create(
                Auth::user(), $plan, $request->all()
            );
        } catch (AbstractIuguException $e) {
            $request->session()->flash('error',$this->getMessageException($e));
            return redirect()->route('site.subscriptions.create');
        }

        return redirect()->route('site.subscriptions.successfully');
    }

    public function successfully()
    {
        return view('site.subscriptions.successfully');
    }

    protected function getMessageException($exception)
    {
        if ($exception instanceof IuguCustomerException) {
            return 'Erro ao processar cliente. Contacte o atendimento para mais detalhes.';
        } elseif ($exception instanceof IuguPaymentMethodException) {
            return 'Erro ao salvar método de pagamento. Contacte o atendimento para mais detalhes.';
        }elseif ($exception instanceof IuguSubscriptionException) {
            return 'Erro ao processar assinatura. Contacte o atendimento para mais detalhes.';
        }
    }
}