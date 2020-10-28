<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Sadegh\User\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_login_by_email()
    {
        $user = User::create(
            [
             'name' => $this->faker->name,
             'email' => $this->faker->safeEmail,
             'password' => bcrypt('12@abA')
            ]
        );

        $this->post(route('login'),[
            'email' => $user->email,
            'password' => '12@abA'
        ]);

        $this->assertAuthenticated();
    }

    public function test_user_can_login_by_mobile()
    {
        $user = User::create(
            [
             'name' => $this->faker->name,
             'email' => $this->faker->safeEmail,
             'mobile' => '987655564',
             'password' => bcrypt('12@abA')
            ]
        );

        $this->post(route('login'),[
            'email' => $user->mobile,
            'password' => '12@abA'
        ]);

        $this->assertAuthenticated();
    }
}
