<?php

namespace Sadegh\User\database\Seeds;

use Illuminate\Database\Seeder;
use Sadegh\User\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (User::$defaultUser as $user) {

            User::firstOrCreate(
                ['email' => $user ['email']]
                ,[
                "email" => $user['email'],
                "name" => $user['name'],
                "password" => bcrypt($user['password'])
            ])->assignRole($user['role'])->markEmailAsVerified();
        }

    }
}
