<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 11/2/2020
 * Time: 12:55 PM
 */

namespace Sadegh\User\Repositories;


use Sadegh\User\Models\User;

class UserRepo
{
    public function findByEmail($email)
    {
       return User::query()->where('email', $email)->firstOrFail();
    }

    public function getTeachers()
    {
        return User::permission('teach')->get();
    }

    public function findById($id)
    {
        return User::findOrFail($id);
    }
}