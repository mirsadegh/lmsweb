<?php
namespace Sadegh\RolePermissions\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Sadegh\RolePermissions\Models\Permission;

class RolePermissionsServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/role_permissions_routes.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations/');
        $this->loadViewsFrom(__DIR__.'/../resources/views/','RolePermissions');
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang');

        Gate::before(function ($user){
            return $user->hasPermissionTo(Permission::PERMISSION_SUPER_ADMIN)? true :null;
        });

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