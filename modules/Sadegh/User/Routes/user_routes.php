<?php

Route::group(['namespace' => 'Sadegh\User\Http\Controllers', 'middleware' => 'web'],
    function ($router) {
//        Auth::routes(['verify' => true]);
        Route::post('/email/verify','Auth\VerificationController@verify')->name('verification.verify');
        Route::post('/email/resend','Auth\VerificationController@resend')->name('verification.resend');
        Route::get('/email/verify','Auth\VerificationController@show')->name('verification.notice');

        //login
        Route::post('/login','Auth\LoginController@login')->name('login');
        Route::get('/login','Auth\LoginController@showLoginForm')->name('login');

        //logout
        Route::post('/logout','Auth\LoginController@logout')->name('logout');

        //reset password
        Route::get('/password/reset','Auth\ForgotPasswordController@showVerifyCodeRequestForm')->name('password.request');
        Route::get('/password/reset/send','Auth\ForgotPasswordController@sendVerifyCodeEmail')->name('password.sendVerifyCodeEmail');


//        Route::get('/password/email','Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
//        Route::post('/password/reset','Auth\ResetPasswordController@reset')->name('password.update');
//        Route::post('/password/reset','Auth\ResetPasswordController@showResetForm')->name('password.reset');

        //register
        Route::get('/register','Auth\RegisterController@showRegistrationForm')->name('register');
        Route::post('/register','Auth\RegisterController@register')->name('register');

    });


