<?php


namespace Sadegh\Course\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Sadegh\Course\Listeners\RegisterUserInTheCourse;
use Sadegh\Payment\Events\PaymentWasSuccessful;


class EventServiceProvider extends ServiceProvider
{

    protected $listen = [

        PaymentWasSuccessful::class =>[
            RegisterUserInTheCourse::class
        ]
    ];
    public function boot()
    {
        //
    }

}
