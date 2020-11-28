<?php

namespace Sadegh\Course\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Models\User;

class SeasonPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function manage(User $user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    public function create($user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
               $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);

    }

    public function edit($user ,$season)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $season->course->teacher_id == $user->id;
    }

    public function delete($user,$season)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $season->course->teacher_id == $user->id) return true;
    }

    public function change_confirmation_status($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        return null;
    }


}
