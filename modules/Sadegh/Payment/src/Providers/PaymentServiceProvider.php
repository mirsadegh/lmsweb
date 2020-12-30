<?php

namespace Sadegh\Payment\Providers;

use Carbon\Laravel\ServiceProvider;
use Sadegh\Course\Models\Course;
use Sadegh\Payment\Gateways\Gateway;
use Sadegh\Payment\Gateways\Zarinpal\ZarinpalAdaptor;
use Sadegh\Payment\Models\Payment;

class PaymentServiceProvider extends ServiceProvider
{
    public $namespace = "Sadegh\Payment\Http\Controllers";
    public function register()
    {
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
        \Route::middleware('web')->namespace($this->namespace)->group(__DIR__."/../Routes/payment_routes.php");
    }


    public function boot()
    {
      $this->app->singleton(Gateway::class,function ($app){
         return new ZarinpalAdaptor();
      });
//
//         Course::resolveRelationUsing("payments",function ($courseModal){
//             return $courseModal->morphMany(Payment::class , "paymentable" );
//         });
    }
}
