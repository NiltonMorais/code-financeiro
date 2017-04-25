<?php

namespace CodeFin\Providers;

use CodeFin\Events\BankStoredEvent;
use CodeFin\Events\BillStoredEvent;
use CodeFin\Listeners\BankAccountUpdateBalanceListener;
use Prettus\Repository\Events\RepositoryEntityCreated;
use CodeFin\Listeners\BankLogoUploadListener;
use CodeFin\Listeners\BankAccountSetDefaultListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Prettus\Repository\Events\RepositoryEntityUpdated;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        BankStoredEvent::class => [
            BankLogoUploadListener::class
        ],
        BillStoredEvent::class => [
            BankAccountUpdateBalanceListener::class
        ],
        RepositoryEntityCreated::class => [
            BankAccountSetDefaultListener::class
        ],
        RepositoryEntityUpdated::class => [
            BankAccountSetDefaultListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
