<?php

namespace Sadegh\Course\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Models\User;

class CoursePolicy
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
}
