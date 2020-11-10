<?php
namespace Sadegh\RolePermissions\Providers;

use Illuminate\Support\ServiceProvider;

class RolePermissionsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/role_permissions_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/');
        $this->loadViewsFrom(__DIR__.'/../resources/views/','RolePermissions');
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang');

    }

    public function boot()
    {
        config()->set('sidebar.items.role-permissions',
            [
                "icon" => "i-role-permissions",
                "title" => "نقشهای کاربری",
                "url" => route('role-permissions.index')
            ]);
    }


}