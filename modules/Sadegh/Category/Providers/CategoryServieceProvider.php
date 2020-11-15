<?php

namespace Sadegh\Category\Providers;

use Illuminate\Support\ServiceProvider;

class CategoryServieceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadRoutesFrom(__DIR__ . '/../Routes/categories_routes.php');
        $this->loadViewsFrom(__DIR__ . '/../Resources/Views/', 'Categories');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    public function boot()
    {
        config()->set('sidebar.items.categories',
            [
                "icon" => "i-courses",
                "title" => "دسته بندی ها",
                "url" => route('categories.index')
            ]);
    }
}