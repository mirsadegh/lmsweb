<?php

namespace Sadegh\Course\Http\Controllers;


use App\Http\Controllers\Controller;
use Sadegh\Course\Http\Requests\LessonRequest;
use Sadegh\Course\Repositories\CourseRepo;
use Sadegh\Course\Repositories\LessonRepo;
use Sadegh\Course\Repositories\SeasonRepo;
use Sadegh\Media\Services\MediaFileServiece;

class LessonController extends Controller
{

    /**
     * @var LessonRepo
     */
    private $lessonRepo;

    public function __construct(LessonRepo $lessonRepo)
    {
        $this->lessonRepo = $lessonRepo;
    }

    public function create($course , SeasonRepo $seasonRepo,CourseRepo $courseRepo)
    {
        $seasons = $seasonRepo->getCourseSeason($course);

        $course = $courseRepo->findById($course);
        return view('Courses::lessons.create',compact('seasons','course'));
    }

    public function store($course, LessonRequest $request)
    {

        $request->request->add(["media_id" => MediaFileServiece::privateUpload($request->file('lesson_file'))->id]);
        $this->lessonRepo->store($course,$request);
        newFeedback();
        return redirect(route('courses.details',$course));

    }
}