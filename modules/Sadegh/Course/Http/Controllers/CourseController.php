<?php


namespace Sadegh\Course\Http\Controllers;


use App\Http\Controllers\Controller;
use Sadegh\Category\Repositories\CategoryRepo;
use Sadegh\Category\Responses\AjaxResponses;
use Sadegh\Course\Http\Requests\CourseRequest;
use Sadegh\Course\Repositories\CourseRepo;
use Sadegh\Media\Providers\MediaServiceProvider;
use Sadegh\Media\Services\MediaFileServiece;
use Sadegh\User\Repositories\UserRepo;

class CourseController extends Controller
{

    public function index(CourseRepo $courseRepo)
    {
       $courses = $courseRepo->paginate();
       return view('Courses::index',compact('courses'));
    }

    public function create(UserRepo $userRepo,CategoryRepo $categoryRepo)
    {
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::create',compact('teachers','categories'));
    }

    public function store(CourseRequest $request,CourseRepo $courseRepo)
    {
        $request->request->add(['banner_id' => MediaFileServiece::upload($request->file('image'))->id]);
          $courseRepo->store($request);
         return redirect()->route('courses.index');
    }

    public function edit($id, CourseRepo $courseRepo,UserRepo $userRepo,CategoryRepo $categoryRepo)
    {

        $course = $courseRepo->findById($id);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();

        return view('Courses::edit',compact('course','teachers','categories'));

    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);

        if ($course->banner){
            $course->banner->delete();
        }

        $course->delete();

        return AjaxResponses::successResponses();

    }

}