<?php

namespace Sadegh\RolePermissions\database\Seeds;

use Illuminate\Database\Seeder;
use Sadegh\RolePermissions\Models\Role;
use Spatie\Permission\Models\Permission;


class RolePermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (\Sadegh\RolePermissions\Models\Permission::$permissions as $permission) {
            Permission::findOrCreate($permission);
        }

        foreach (\Sadegh\RolePermissions\Models\Role::$roles as $name => $permissions){
            Role::findOrCreate($name)->givePermissionTo($permissions);
        }



    }
}
