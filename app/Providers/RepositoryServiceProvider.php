<?php

namespace CodeFin\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\CodeFin\Repositories\Interfaces\BankRepository::class, \CodeFin\Repositories\BankRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\BankAccountRepository::class, \CodeFin\Repositories\BankAccountRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\ClientRepository::class, \CodeFin\Repositories\ClientRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\CategoryExpenseRepository::class, \CodeFin\Repositories\CategoryExpenseRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\CategoryRevenueRepository::class, \CodeFin\Repositories\CategoryRevenueRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\BillPayRepository::class, \CodeFin\Repositories\BillPayRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\BillReceiveRepository::class, \CodeFin\Repositories\BillReceiveRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\UserRepository::class, \CodeFin\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\StatementRepository::class, \CodeFin\Repositories\StatementRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\PlanRepository::class, \CodeFin\Repositories\PlanRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\SubscriptionRepository::class, \CodeFin\Repositories\SubscriptionRepositoryEloquent::class);
        $this->app->bind(\CodeFin\Repositories\Interfaces\OrderRepository::class, \CodeFin\Repositories\OrderRepositoryEloquent::class);
        //:end-bindings:
    }
}
