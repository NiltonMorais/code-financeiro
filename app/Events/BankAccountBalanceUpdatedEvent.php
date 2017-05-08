<?php

namespace CodeFin\Events;

use CodeFin\Models\BankAccount;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BankAccountBalanceUpdatedEvent implements ShouldBroadcast
{
    /**
     * @var BankAccount
     */
    public $bankAccount;

    public function __construct(BankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    public function broadcastOn()
    {
        return new PrivateChannel("client.{$this->bankAccount->client_id}");
    }
}
