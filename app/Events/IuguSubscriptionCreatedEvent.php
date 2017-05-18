<?php

namespace CodeFin\Events;

use CodeFin\Models\Bank;
use Illuminate\Http\UploadedFile;

class IuguSubscriptionCreatedEvent
{
    private $iuguSubscription;
    private $userId;
    private $planId;

    /**
     * IuguSubscriptionCreatedEvent constructor.
     * @param $iuguSubscription
     * @param $userId
     * @param $planId
     */
    public function __construct($iuguSubscription, $userId, $planId)
    {
        $this->iuguSubscription = $iuguSubscription;
        $this->userId = $userId;
        $this->planId = $planId;
    }

    /**
     * @return mixed
     */
    public function getIuguSubscription()
    {
        return $this->iuguSubscription;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getPlanId()
    {
        return $this->planId;
    }



}
