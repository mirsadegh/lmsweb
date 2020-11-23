<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 11/23/2020
 * Time: 11:50 AM
 */

namespace Sadegh\Common\Providers;


use Illuminate\Support\ServiceProvider;

class CommonServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadViewsFrom(__DIR__."/../Resources/",'Common');
    }

    public function boot()
    {
        require __DIR__."/../helpers.php";
     }
    
}