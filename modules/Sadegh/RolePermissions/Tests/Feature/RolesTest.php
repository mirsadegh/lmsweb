<?php

namespace Sadegh\RolePermissions\Tests\Feature;



use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Sadegh\Category\Models\Category;
use Sadegh\RolePermissions\database\Seeds\RolePermissionTableSeeder;
use Sadegh\RolePermissions\Models\Permission;
use Sadegh\RolePermissions\Models\Role;
use Sadegh\User\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;


class RolesTest extends TestCase
{

    use withFaker;
    use RefreshDatabase;

    public function test_permitted_user_can_see_index()
    {
        $this->actAsAdmin();
        $this->get(route('role-permissions.index'))->assertOk();
    }

    public function test_normal_user_can_not_see_index()
    {
        $this->actAsUser();
        $this->get(route('role-permissions.index'))->assertStatus(403);
    }

    public function test_permitted_user_can_store_roles()
    {
        $this->actAsAdmin();
        $this->post(route('role-permissions.store'), [
            "name" => "testtest",
            "permissions" => [
                Permission::PERMISSION_MANAGE_COURSES,
                Permission::PERMISSION_TEACH
            ]
        ])->assertRedirect(route('role-permissions.index'));
        $this->assertEquals(count(Role::$roles) + 1,Role::count());
    }

    public function test_normal_user_can_not_store_roles()
    {
        $this->actAsUser();
        $this->post(route('role-permissions.store'), [
            "name" => "testtest",
            "permissions" => [
                Permission::PERMISSION_MANAGE_COURSES,
                Permission::PERMISSION_TEACH
            ]
        ])->assertStatus(403);
        $this->assertEquals(count(Role::$roles),Role::count());
    }

    public function test_permitted_user_can_see_edit()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertOk();
    }

    public function test_normal_user_can_not_see_edit()
    {
        $this->actAsUser();
        $role = $this->createRole();
        $this->get(route('role-permissions.edit', $role->id))->assertStatus(403);
    }

    public function test_permitted_user_can_update_roles()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id), [
            "name" => "testtest2323",
            "id" => $role->id,
            "permissions" => [
                Permission::PERMISSION_TEACH
            ]
        ])->assertRedirect(route('role-permissions.index'));
        $this->assertEquals("testtest2323", $role->fresh()->name);
    }

    public function test_normal_user_can_not_update_roles()
    {
        $this->actAsUser();
        $role = $this->createRole();
        $this->patch(route('role-permissions.update', $role->id), [
            "name" => "testtest2323",
            "id" => $role->id,
            "permissions" => [
                Permission::PERMISSION_TEACH
            ]
        ])->assertStatus(403);
        $this->assertEquals($role->name, $role->fresh()->name);
    }

    public function test_permitted_user_can_delete_role()
    {
        $this->actAsAdmin();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertOk();
        $this->assertEquals(count(Role::$roles), Role::count());
    }

    public function test_normal_user_can_not_delete_role()
    {
        $this->actAsUser();
        $role = $this->createRole();
        $this->delete(route('role-permissions.destroy', $role->id))->assertStatus(403);
        $this->assertEquals(count(Role::$roles) + 1 , Role::count() );
    }

    private function createUser()
    {
        $this->actingAs(User::factory()->create());
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function actAsUser()
    {
        $this->createUser();
    }

    private function actAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_ROLE_PERMISSIONS);
    }

    private function actionAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    public function createRole()
    {
        return Role::create(["name" => "testtest",])->syncPermissions([ Permission::PERMISSION_MANAGE_COURSES,
            Permission::PERMISSION_TEACH]);
    }

}
