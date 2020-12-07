<?php

namespace Sadegh\Front\Providers;

use Carbon\Laravel\ServiceProvider;
use Sadegh\Category\Repositories\CategoryRepo;

class FrontServiceProvider extends ServiceProvider
{
    public function register()
    {
       $this->loadRoutesFrom(__DIR__ . "/../Routes/front_routes.php");
       $this->loadViewsFrom(__DIR__ . "/../Resources/Views","Front");

       view()->composer('Front::layout.header',function ($view){
           $categories = (new CategoryRepo())->tree();
           $view->with(compact('categories'));
       });

    }
}
