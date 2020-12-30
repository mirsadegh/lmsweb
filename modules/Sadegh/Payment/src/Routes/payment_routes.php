<?php

Route::group([],function ($router){
//    $router->any("payments/callback","PaymentController@callback")->name('payments.callback');
    $router->get("paymentPay/callback","PaymentController@callbackpay")->name('paymentpay.callback');
});
