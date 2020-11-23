<?php


namespace Sadegh\User\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Sadegh\User\Models\User;
use Sadegh\User\Policies\UserPolicy;

class UserServiceProvider extends ServiceProvider
{

    public function register()
    {
       config()->set('auth.providers.users.model', User::class);
       Gate::policy(User::class,UserPolicy::class);
    }

    public function boot()
    {
      $this->loadRoutesFrom(__DIR__.'/../Routes/user_routes.php');
      $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
      $this->loadFactoriesFrom(__DIR__.'/../Database/factories');
      $this->loadViewsFrom(__DIR__.'/../resources/views','User');


        config()->set('sidebar.items.users',
            [
                "icon" => "i-users",
                "title" => "کاربران",
                "url" => route('users.index')
            ]);


    }
}