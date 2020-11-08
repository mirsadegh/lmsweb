<?php

Route::group(["namespace" => "Sadegh\Category\Http\Controllers",'middleware' =>['web','auth','verified']],function ($router){
       $router->resource('categories','CategoryController');
});