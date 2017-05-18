<?php

namespace CodeFin\Mail;

use CodeFin\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class FirstSubscriptionPaid extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var Subscription
     */
    public $subscription;
    public $user;

    /**
     * Create a new message instance.
     *
     * @param Subscription $subscription
     */
    public function __construct(Subscription $subscription)
    {
        $this->subscription = $subscription;
        $this->user = $subscription->user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Sua assinatura está ativa')
            ->view('emails.subscription_paid');
    }
}
