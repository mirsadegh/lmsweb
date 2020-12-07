<?php


namespace Sadegh\User\Providers;


use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Http\Middleware\StoreUserIp;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Sadegh\User\database\Seeds\UsersTableSeeder;
use Sadegh\User\Models\User;
use Sadegh\User\Policies\UserPolicy;
use Illuminate\Database\Eloquent\Factories\Factory;

class
UserServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../Routes/user_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');
//        $this->loadFactoriesFrom(__DIR__.'/../Database/factories');
        $this->loadViewsFrom(__DIR__.'/../resources/views','User');
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang');

        //for register middleware
        $this->app['router']->pushMiddlewareToGroup('web',StoreUserIp::class);

        Factory::guessFactoryNamesUsing(function (string $modelName){
              return  'Sadegh\User\Database\Factories\\' .class_basename($modelName).'Factory';
        });

        config()->set('auth.providers.users.model', User::class);
        Gate::policy(User::class,UserPolicy::class);
        DatabaseSeeder::$seeders[] = UsersTableSeeder::class;
    }

    public function boot()
    {
        config()->set('sidebar.items.users',
            [
                "icon" => "i-users",
                "title" => "کاربران",
                "url" => route('users.index'),
                "permission" => Permission::PERMISSION_MANAGE_Users
            ]);

        $this->app->booted(function (){

            config()->set('sidebar.items.usersInformation',
                [
                    "icon" => "i-user__inforamtion",
                    "title" => "اطلاعات کاربری",
                    "url" => route('users.profile')
                ]);

        });


    }
}
