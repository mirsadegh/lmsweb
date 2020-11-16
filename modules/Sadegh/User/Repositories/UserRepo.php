<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 11/2/2020
 * Time: 12:55 PM
 */

namespace Sadegh\User\Repositories;


use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
       return User::query()->where('email', $email)->first();
    }

    public function getTeachers()
    {
        return User::permission(Permission::PERMISSION_TEACH)->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }
}