<?php


namespace Sadegh\Course\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Sadegh\RolePermissions\Models\Permission;

class LessonPolicy
{
    use HandlesAuthorization;

    public function edit( $user , $lesson)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $user->id == $lesson->course->teacher_id))
        {
            return true;
        }
    }
    public function delete( $user , $lesson)
    {

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $user->id == $lesson->course->teacher_id))
        {
            return true;
        }
    }


}