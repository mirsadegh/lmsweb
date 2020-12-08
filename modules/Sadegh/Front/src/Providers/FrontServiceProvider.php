<?php

namespace Sadegh\Front\Providers;

use Carbon\Laravel\ServiceProvider;
use Sadegh\Category\Repositories\CategoryRepo;
use Sadegh\Course\Repositories\CourseRepo;

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

       view()->composer('Front::layout.latestCourses',function ($view){
           $latestCourses = (new CourseRepo())->latestCourses();
           $view->with(compact('latestCourses'));
       });

    }
}
