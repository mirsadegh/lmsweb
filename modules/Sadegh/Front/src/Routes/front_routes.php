<?php

Route::group(['middleware' => ['web'], 'namespace' => 'Sadegh\Front\Http\Controllers'],
    function ($router) {
        $router->get('/', 'FrontController@index');
        $router->get('/c-{slug}', 'FrontController@singleCourse')->name('singleCourse');
    });


