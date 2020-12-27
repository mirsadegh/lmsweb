<?php

namespace Sadegh\Payment\Providers;

use Carbon\Laravel\ServiceProvider;

class PaymentServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
    }

    public function boot()
    {

    }
}
