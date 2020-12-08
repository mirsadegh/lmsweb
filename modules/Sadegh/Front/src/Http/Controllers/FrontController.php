<?php

namespace Sadegh\Front\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Sadegh\Course\Repositories\CourseRepo;

class FrontController extends Controller
{
    public function index()
    {
        return view('Front::index');
    }

    public function singleCourse($slug,CourseRepo $courseRepo)
    {
        $courseId = Str::before(Str::after($slug,'c-'),'-');
        $course = $courseRepo->findById($courseId);
        return view("Front::singleCourse",compact('course'));
    }
}
