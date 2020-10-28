<?php

Route::group(['namespace' => 'Sadegh\User\Http\Controllers', 'middleware' => 'web'],
    function ($router) {
        Auth::routes(['verify' => true]);
    });


