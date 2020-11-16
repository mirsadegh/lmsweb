<?php


namespace Sadegh\Category\policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Models\User;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function manage(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }

}