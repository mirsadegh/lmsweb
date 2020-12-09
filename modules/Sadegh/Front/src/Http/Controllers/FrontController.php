<?php

namespace Sadegh\Front\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Sadegh\Course\Repositories\CourseRepo;
use Sadegh\Course\Repositories\LessonRepo;

class FrontController extends Controller
{
    public function index()
    {
        return view('Front::index');
    }

    public function singleCourse($slug,CourseRepo $courseRepo,LessonRepo $lessonRepo)
    {
        $courseId = $this->extractId($slug,'c');
        $course = $courseRepo->findById($courseId);
        $lessons = $lessonRepo->getAcceptedLessons($courseId);

        if (request()->lesson){
             $lesson = $lessonRepo->getLesson($courseId, $this->extractId(request()->lesson,'l') );
        }else{
            $lesson = $lessonRepo->getFirstLesson($courseId);
        }

        return view("Front::singleCourse",compact('course','lessons','lesson'));
    }

    public function extractId($slug,$key)
    {
        return  Str::before(Str::after($slug,$key.'-'),'-');
    }
}
