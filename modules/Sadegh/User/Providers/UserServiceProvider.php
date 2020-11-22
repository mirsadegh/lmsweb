<?php


namespace Sadegh\User\Providers;


use Illuminate\Support\ServiceProvider;
use Sadegh\User\Models\User;

class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
       config()->set('auth.providers.users.model', User::class);
    }

    public function boot()
    {
      $this->loadRoutesFrom(__DIR__.'/../Routes/user_routes.php');
      $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
//      $this->loadFactoriesFrom(__DIR__.'/../Database/factories');
      $this->loadViewsFrom(__DIR__.'/../resources/views','User');
    }
}