<?php

namespace Sadegh\Course\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Sadegh\Category\Models\Category;
use Sadegh\RolePermissions\database\Seeds\RolePermissionTableSeeder;
use Sadegh\Course\Models\Course;
use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Models\User;
use Tests\TestCase;

class SeasonTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_permitted_user_can_see_course_details_page()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->get(route('courses.details', $course->id))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->get(route('courses.details', $course->id))->assertOk();

        $this->actionAsSuperAdmin();
        $this->get(route('courses.details', $course->id))->assertOk();
    }

    public function test_not_permitted_user_can_not_see_course_details_page()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->actAsUser();
        $this->get(route('courses.details', $course->id))->assertStatus(403);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('courses.details', $course->id))->assertStatus(403);
    }

    public function test_permitted_user_can_create_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->assertEquals(1, Season::count());

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title 2",
        ]);
        $this->assertEquals(2, Season::count());

        $this->assertEquals(2, Season::find(2)->number);
    }

    public function test_not_permitted_user_can_not_create_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();

        $this->actAsUser();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title 2",
        ])->assertStatus(403);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title 2",
        ])->assertStatus(403);

    }

    public function test_permitted_user_can_see_edit_season_page()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->get(route('seasons.edit', 1))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->get(route('seasons.edit', 1))->assertOk();

    }

    public function test_not_permitted_user_can_not_see_edit_season_page()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);

        $this->actAsUser();
        $this->get(route('seasons.edit', 1))->assertStatus(403);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->get(route('seasons.edit', 1))->assertStatus(403);

    }

    public function test_permitted_user_can_update_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->assertEquals(1, Season::count());
        $this->patch(route('seasons.edit', 1), [
            "title" => "title 2"
        ]);

        $this->assertEquals("title 2", Season::find(1)->title);


        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->patch(route('seasons.edit', 1), [
            "title" => "title 3",
            "number" => 5
        ]);
        $this->assertEquals("title 3", Season::find(1)->title);
        $this->assertEquals(5, Season::find(1)->number);
    }

    public function test_not_permitted_user_can_not_update_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->assertEquals(1, Season::count());

        $this->actAsUser();
        $this->patch(route('seasons.edit', 1), [
            "title" => "title 2"
        ])->assertStatus(403);

        $this->assertEquals("test season title", Season::find(1)->title);

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->patch(route('seasons.edit', 1), [
            "title" => "title 2"
        ])->assertStatus(403);

        $this->assertEquals("test season title", Season::find(1)->title);
    }

    public function test_permitted_user_can_delete_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->assertEquals(1, Season::count());

        $this->delete(route('seasons.destroy', 1))->assertOk();
        $this->assertEquals(0, Season::count());

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);

        $this->delete(route('seasons.destroy', 2))->assertOk();
        $this->assertEquals(0, Season::count());
    }

    public function test_not_permitted_user_can_not_delete_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->assertEquals(1, Season::count());

        $this->actAsUser();
        $this->delete(route('seasons.destroy', 1))->assertStatus(403);
        $this->assertEquals(1, Season::count());

        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $this->delete(route('seasons.destroy', 1))->assertStatus(403);
        $this->assertEquals(1, Season::count());
    }

    public function test_permitted_user_can_accept_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->assertEquals(1, Season::count());

        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(1)->confirmation_status);
        $this->patch(route('seasons.accept', 1))->assertOk();
        $this->assertEquals(Season::CONFIRMATION_STATUS_ACCEPTED, Season::find(1)->confirmation_status);

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title 2",
            "number" => '2'
        ]);

        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(2)->confirmation_status);
        $this->patch(route('seasons.accept', 1))->assertStatus(403);
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(2)->confirmation_status);
    }

    public function test_permitted_user_can_reject_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->assertEquals(1, Season::count());

        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(1)->confirmation_status);
        $this->patch(route('seasons.reject', 1))->assertOk();
        $this->assertEquals(Season::CONFIRMATION_STATUS_REJECTED, Season::find(1)->confirmation_status);

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title 2",
            "number" => '2'
        ]);

        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(2)->confirmation_status);
        $this->patch(route('seasons.reject', 1))->assertStatus(403);
        $this->assertEquals(Season::CONFIRMATION_STATUS_PENDING, Season::find(2)->confirmation_status);
    }

    public function test_permitted_user_can_lock_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->assertEquals(1, Season::count());

        $this->assertEquals(Season::STATUS_OPENED, Season::find(1)->status);
        $this->patch(route('seasons.lock', 1))->assertOk();
        $this->assertEquals(Season::STATUS_LOCKED, Season::find(1)->status);

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title 2",
            "number" => '2'
        ]);

        $this->assertEquals(Season::STATUS_OPENED, Season::find(2)->status);
        $this->patch(route('seasons.lock', 1))->assertStatus(403);
        $this->assertEquals(Season::STATUS_OPENED, Season::find(2)->status);
    }

    public function test_permitted_user_can_unlock_season()
    {
        $this->actAsAdmin();
        $course = $this->createCourse();
        $this->post(route('seasons.store', $course->id), [
            'title' => "test season title",
            "number" => '1'
        ]);
        $this->patch(route('seasons.lock', 1))->assertOk();
        $this->assertEquals(1, Season::count());


        $this->assertEquals(Season::STATUS_LOCKED, Season::find(1)->status);
        $this->patch(route('seasons.unlock', 1))->assertOk();
        $this->assertEquals(Season::STATUS_OPENED, Season::find(1)->status);

        $this->patch(route('seasons.lock', 1))->assertOk();

        $this->actAsUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_OWN_COURSES);
        $course->teacher_id = auth()->id();
        $course->save();
        $this->assertEquals(Season::STATUS_LOCKED, Season::find(1)->status);
        $this->patch(route('seasons.lock', 1))->assertStatus(403);
        $this->assertEquals(Season::STATUS_LOCKED, Season::find(1)->status);
    }






    public function actAsAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    public function actAsSuperAdmin()
    {
        $this->createUser();
        auth()->user()->givePermissionTo(Permission::PERMISSION_MANAGE_COURSES);
    }

    public function actAsUser()
    {
        $this->createUser();
    }

    public function createUser()
    {
        $user = User::create(
            [
                'name' => $this->faker->name,
                'email' => $this->faker->unique()->safeEmail,
                'email_verified_at' => now(),
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                'remember_token' => Str::random(10),
            ]
        );

        $this->actingAs($user);
        $this->seed(RolePermissionTableSeeder::class);
    }

    private function createCourse()
    {

        $data = $this->courseData() + ['confirmation_status' => Course::CONFIRMATION_STATUS_PENDING];
        unset($data['image']);
        return Course::create($data);

    }

    private function createCategory()
    {
        return Category::create(['title' => $this->faker->word, "slug" => $this->faker->word]);

    }

    private function courseData()
    {
        $category = $this->createCategory();
        return [
            'title' => $this->faker->sentence(2),
            "slug" => $this->faker->sentence(2),
            'teacher_id' => auth()->id(),
            'category_id' => $category->id,
            "priority" => 12,
            "price" => 1200,
            "percent" => 70,
            "type" => Course::TYPE_FREE,
            'image' => UploadedFile::fake()->image('banner.jpg'),
            'status' => Course::STATUS_COMPLETED,
        ];
    }
}
