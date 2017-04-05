<?php

namespace CodeFin\Listeners;

use CodeFin\Repositories\Interfaces\BankAccountRepository;
use Prettus\Repository\Events\RepositoryEventBase;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class BankAccountSetDefaultListener
{
    /**
     * @var BankAccountRepository
     */
    private $repository;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(BankAccountRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->skipPresenter(true);
    }

    /**
     * Handle the event.
     *
     * @param  RepositoryEventBase  $event
     * @return void
     */
    public function handle(RepositoryEventBase $event)
    {
        $model = $event->getModel();
        if(!$model->default){
            return;
        }

        $collection = $this->repository
            ->findByField('default',true)
            ->filter(function($value, $key) use($model){
                return $model->id != $value->id;
            });

        $bankAccountDefault = $collection->first();
        if($bankAccountDefault){
            $this->repository->update(['default'=>false],$bankAccountDefault->id);
        }
    }
}
