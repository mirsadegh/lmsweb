<?php


namespace Sadegh\Course\Providers;



use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Sadegh\Course\database\Seeds\RolePermissionTableSeeder;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Policies\CoursePolicy;


class CourseServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/courses_routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views/','Courses');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadJsonTranslationsFrom(__DIR__.'/../resources/lang/');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang/',"Courses");
        DatabaseSeeder::$seeders[] = RolePermissionTableSeeder::class;
        Gate::policy(Course::class,CoursePolicy::class);


    }

    public function boot()
    {
        config()->set('sidebar.items.courses',
            [
                "icon" => "i-categories",
                "title" => "دوره ها",
                "url" => route('courses.index')
            ]);
    }
    
}