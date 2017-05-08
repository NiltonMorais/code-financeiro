<?php

namespace CodeFin\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Broadcast::routes(['middleware'=>['web','cors','auth:api']]);

        /*
         * Authenticate the user's personal channel...
         */
        Broadcast::channel('client.*', function ($user, $clientId) {
            return (int) $user->client_id === (int) $clientId;
        });
    }
}
