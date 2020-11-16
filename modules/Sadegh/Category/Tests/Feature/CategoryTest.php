<?php

namespace Sadegh\Category\Tests\Feature;


use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Sadegh\Category\Models\Category;
use Sadegh\Course\database\Seeds\RolePermissionTableSeeder;
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

        $this->actionAsAdmin();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
        $this->get(route('categories.index'))->assertOk();

    }
    public function test_normal_user_can_not_see_categories_panel()
    {

        $this->actionAsAdmin();
        $this->get(route('categories.index'))->assertStatus(403);

    }

    public function test_permitted_user_can_create_category()
    {
        $this->withoutExceptionHandling();
        $this->actionAsAdmin();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
        $this->createCategory();

        $this->assertEquals(1, Category::all()->count());

    }

    public function test_permitted_user_can_update_category()
    {
        $newTitle = "assdddff";
        $this->withoutExceptionHandling();
        $this->actionAsAdmin();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());
        $this->patch(route('categories.update', 1), ['title' => $newTitle, "slug" => $this->faker]);

        $this->assertEquals(1, Category::whereTitle($newTitle)->count());
    }

    public function test_user_can_delete_category()
    {
        $this->actionAsAdmin();
        $this->seed(RolePermissionTableSeeder::class);
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_CATEGORIES);
        $this->createCategory();
        $this->assertEquals(1, Category::all()->count());

        $this->delete(route('categories.destroy', 1))->assertOk();
    }

    public function actionAsAdmin()
    {
        $user = User::create(
            [
                'name' => $this->faker->name,
                'email' => $this->faker->safeEmail,
                'mobile' => '987655564',
                'password' => bcrypt('12@abA')
            ]
        );
        $this->actingAs($user);
    }

    private function createCategory()
    {
        $this->post(route('categories.store'), ['title' => $this->faker->word, "slug" => $this->faker]);
    }


}