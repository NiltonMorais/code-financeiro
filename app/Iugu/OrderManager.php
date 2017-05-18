<?php

namespace CodeFin\Iugu;


use Carbon\Carbon;
use CodeFin\Models\Order;
use CodeFin\Repositories\Interfaces\OrderRepository;
use CodeFin\Repositories\Interfaces\SubscriptionRepository;

class OrderManager
{
    /**
     * @var IuguSubscriptionClient
     */
    private $iuguSubscriptionClient;
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;
    /**
     * @var OrderRepository
     */
    private $orderRepository;
    /**
     * @var IuguInvoiceClient
     */
    private $iuguInvoiceClient;

    /**
     * OrderManager constructor.
     * @param IuguSubscriptionClient $iuguSubscriptionClient
     * @param SubscriptionRepository $subscriptionRepository
     * @param OrderRepository $orderRepository
     */
    public function __construct(IuguSubscriptionClient $iuguSubscriptionClient,
                                IuguInvoiceClient $iuguInvoiceClient,
                                SubscriptionRepository $subscriptionRepository,
                                OrderRepository $orderRepository)
    {
        $this->iuguSubscriptionClient = $iuguSubscriptionClient;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->orderRepository = $orderRepository;
        $this->iuguInvoiceClient = $iuguInvoiceClient;
    }

    public function create(array $data)
    {
        $iuguSubscription = $this->iuguSubscriptionClient->find($data['subscription_id']);
        $subscription = $this->subscriptionRepository->findByField('code', $iuguSubscription->id)->first();
        if ($subscription) {
            $invoice = $iuguSubscription->recent_invoices[0];
            $total = $this->getValue($invoice->total);
            return $this->orderRepository->create([
                'date_due' => $invoice->due_date,
                'code' => $invoice->id,
                'subscription_id' => $subscription->id,
                'value' => $total,
                'status' => $invoice->status == 'paid' ? Order::STATUS_PAID : Order::STATUS_PENDING,
                'payment_date' => $invoice->status == 'paid' ? (new Carbon())->format('Y-m-d') : null,
                'payment_url' => $invoice->secure_url
            ]);
        }
    }

    public function paid(array $data)
    {
        $invoice = $this->iuguInvoiceClient->find($data['id']);
        $order = $this->orderRepository->findByField('code',$invoice->id)->first();
        if($order && $order->status != Order::STATUS_PAID){
            $this->orderRepository->update([
                'status' => Order::STATUS_PAID,
                'payment_date' => (new Carbon())->format('Y-m-d')
            ], $order->id);
        }
    }

    protected function getValue($value)
    {
        $value = str_replace(' ', '', $value);
        $curr = "R$";
        $numberFormat = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);
        return $numberFormat->parseCurrency($value, $curr);
    }
}