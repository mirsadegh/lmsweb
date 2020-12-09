<?php


namespace Sadegh\Media\Providers;

use Illuminate\Support\ServiceProvider;

class MediaServiceProvider extends ServiceProvider
{
    protected $namespace = 'Sadegh\Media\Http\Controllers';
    public function register()
    {
        \Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__.'/../Routes/media_routes.php');

//        $this->loadRoutesFrom(__DIR__.'/../routes/media_routes.php');
//        $this->loadViewsFrom(__DIR__.'/../resources/views/','Media');
          $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
//        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang/');
//        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/',"Media");
          $this->mergeConfigFrom(__DIR__.'/../Config/mediaFile.php','mediaFile');

    }


    public function boot()
    {

    }
}
