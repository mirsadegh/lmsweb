<?php


namespace Sadegh\Course\Providers;




use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Sadegh\Course\Models\Lesson;
use Sadegh\Course\Policies\LessonPolicy;
use Sadegh\Course\Policies\SeasonPolicy;
use Sadegh\RolePermissions\database\Seeds\RolePermissionTableSeeder;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Models\Season;
use Sadegh\Course\Policies\CoursePolicy;
use Sadegh\RolePermissions\Models\Permission;


class CourseServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/courses_routes.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/seasons_routes.php');
        $this->loadRoutesFrom(__DIR__.'/../routes/lessons_routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views/','Courses');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang/');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/',"Courses");

        Gate::policy(Course::class,CoursePolicy::class);
        Gate::policy(Season::class,SeasonPolicy::class);
        Gate::policy(Lesson::class,LessonPolicy::class);


    }

    public function boot()
    {
        config()->set('sidebar.items.courses',
            [
                "icon" => "i-categories",
                "title" => "دوره ها",
                "url" => route('courses.index'),
                "permission" => Permission::PERMISSION_MANAGE_COURSES
            ]);
    }
    
}