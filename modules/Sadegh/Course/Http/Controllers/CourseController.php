<?php


namespace Sadegh\Course\Http\Controllers;


use App\Http\Controllers\Controller;
use Sadegh\Category\Repositories\CategoryRepo;
use Sadegh\Common\Responses\AjaxResponses;
use Sadegh\Course\Http\Requests\UpdateUserRequest;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Repositories\CourseRepo;
use Sadegh\Media\Providers\MediaServiceProvider;
use Sadegh\Media\Services\MediaFileServiece;
use Sadegh\User\Repositories\UserRepo;

class CourseController extends Controller
{

    public function index(CourseRepo $courseRepo)
    {
        $this->authorize('manage', Course::class);
        $courses = $courseRepo->paginate();
        return view('Courses::index', compact('courses'));
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $this->authorize('create', Course::class);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::create', compact('teachers', 'categories'));
    }

    public function store(UpdateUserRequest $request, CourseRepo $courseRepo)
    {

        $request->request->add(['banner_id' => MediaFileServiece::upload($request->file('image'))->id]);
        $courseRepo->store($request);
        return redirect()->route('courses.index');
    }

    public function edit($id, CourseRepo $courseRepo, UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('edit',$course);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();

        return view('Courses::edit', compact('course', 'teachers', 'categories'));

    }

    public function update($id, UpdateUserRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('edit',$course);
        if ($request->hasFile('image')) {
            $request->request->add(['banner_id' => MediaFileServiece::upload($request->file('image'))->id]);
            if ($course->banner)
            $course->banner->delete();
        } else {
            $request->request->add(['banner_id' => $course->banner_id]);

        }
        $courseRepo->update($id, $request);

        return redirect(route('courses.index'));
    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('delete',$course);
        if ($course->banner) {
            $course->banner->delete();
        }

        $course->delete();

        return AjaxResponses::successResponses();

    }

    public function accept($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status',Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::FailedResponse();

    }

    public function reject($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status',Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::FailedResponse();

    }

    public function lock($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status',Course::class);
        if ($courseRepo->updateStatus($id, Course::STATUS_LOCKED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::FailedResponse();

    }


}