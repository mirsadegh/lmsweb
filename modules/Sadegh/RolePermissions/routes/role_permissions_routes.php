<?php

Route::group(["namespace" => "Sadegh\RolePermissions\Http\Controllers",'middleware' =>['web','auth','verified']],
    function ($router){
    $router->resource('role-permissions','RolePermissionsController')->middleware('permission:manage role_permissions');
});

