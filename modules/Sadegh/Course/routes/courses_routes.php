<?php

Route::group(["namespace" => "Sadegh\Course\Http\Controllers",'middleware' =>['web','auth','verified']],function ($router){
    $router->resource('courses','CourseController');
});