<?php


namespace Sadegh\Media\Providers;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    public function register()
    {
//        $this->loadRoutesFrom(__DIR__.'/../routes/media_routes.php');
//        $this->loadViewsFrom(__DIR__.'/../resources/views/','Media');
          $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
//        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang/');
//        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/',"Media");

    }


    public function boot()
    {

    }
}