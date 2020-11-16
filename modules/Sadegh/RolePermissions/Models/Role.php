<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 11/15/2020
 * Time: 11:23 PM
 */

namespace Sadegh\RolePermissions\Models;


class Role extends \Spatie\Permission\Models\Role
{


    const ROLE_TEACHER = 'teacher';

    static $roles = [
        self::ROLE_TEACHER => [
            Permission::PERMISSION_TEACH,
        ]
    ];


}