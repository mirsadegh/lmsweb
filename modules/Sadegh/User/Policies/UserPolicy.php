<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 11/22/2020
 * Time: 5:23 PM
 */

namespace Sadegh\User\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Sadegh\RolePermissions\Models\Permission;

class UserPolicy
{
     use HandlesAuthorization;

    public function index($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_Users)){
            return true;
        }
     }
     public function addRole($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_Users)){
            return true;
        }
     }
}