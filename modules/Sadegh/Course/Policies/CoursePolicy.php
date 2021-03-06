<?php

namespace Sadegh\Course\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Repositories\CourseRepo;
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

    public function index($user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)||
               $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
    }


    public function create($user)
    {
        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
               $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);

    }

    public function edit($user ,$course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;

        return $user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id;
    }

    public function delete($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
    }

    public function change_confirmation_status($user)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)) return true;
        return null;
    }

    public function details($user , $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)){
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id){
            return true;
        }
    }

    public function createLesson($user, $course)
    {
//        if ($user->hasPermissonTo(Permission::PERMISSION_MANAGE_COURSES) ||
//            ($user->hasPermissonTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id)
//        ) return true;

//        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)){
//            return true;
//        }
//        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id){
//            return true;
//        }

        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id)
        ) return true;

    }

    public function createSeason($user,$course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES)){
            return true;
        }
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES) && $course->teacher_id == $user->id){
            return true;
        }
    }

    public function download($user, $course)
    {
        if ($user->hasPermissionTo(Permission::PERMISSION_MANAGE_COURSES) ||
            ($user->id === $course->teacher_id) ||
            $course->hasStudent($user->id)
        ) return true;
        return false;
    }


}
