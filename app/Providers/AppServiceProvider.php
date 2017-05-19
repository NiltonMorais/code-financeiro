<?php

namespace CodeFin\Providers;

use CodeFin\Jwt\Manager;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(app()->environment('prod')){
            URL::forceSchema('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Iugu::setApiKey(env('IUGU_API_KEY'));
    }
}
