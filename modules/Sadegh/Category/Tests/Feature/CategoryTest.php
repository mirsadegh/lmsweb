<?php

namespace Sadegh\Category\Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Sadegh\Category\Models\Category;
use Sadegh\RolePermissions\database\Seeds\RolePermissionTableSeeder;
use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    public function test_permitted_user_can_see_categories_panel()
    {
        $this->withoutExceptionHandling();
        $this->actionAsAdmin();
        $this->get(route('categories.index'))->assertOk();
    }
    public function test_normal_user_can_not_see_categories_panel()
    {

        $this->actionAsUser();
        $this->get(route('categories.index'))->assertStatus(403);

    }

    public function test_permitted_user_can_create_category()
    {
        $this->withoutExceptionHandling();
        $this->actionAsAdmin();
        $this->createCategory();

        $this->assertEquals(1, Category::all()->count());

    }

    public function test_permitted_user_can_update_category()
    {
        $newTitle = "assdddff";
        $this->withoutExceptionHandling();
        $this->actionAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());
        $this->patch(route('categories.update', 1), ['title' => $newTitle, "slug" => $this->faker]);

        $this->assertEquals(1, Category::whereTitle($newTitle)->count());
    }

    public function test_user_can_delete_category()
    {
        $this->actionAsAdmin();
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());

        $this->delete(route('categories.destroy', 1))->assertOk();
    }

    public function actionAsAdmin()
    {
        $user = User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
        $this->actingAs($user);
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
    }

    public function actionAsUser()
    {
        $this->actingAs(factory(User::class)->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function createCategory()
    {
      return  $this->post(route('categories.store'), ['title' => $this->faker->word, "slug" => $this->faker]);
    }


}