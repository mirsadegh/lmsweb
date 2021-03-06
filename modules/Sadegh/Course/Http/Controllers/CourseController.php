<?php


namespace Sadegh\Course\Http\Controllers;


use App\Http\Controllers\Controller;
use Sadegh\Category\Repositories\CategoryRepo;
use Sadegh\Common\Responses\AjaxResponses;
use Sadegh\Course\Http\Requests\CourseRequest;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Repositories\CourseRepo;
use Sadegh\Course\Repositories\LessonRepo;
use Sadegh\Media\Services\MediaFileServiece;
use Sadegh\Payment\Gateways\Gateway;
use Sadegh\Payment\Services\PaymentServices;
use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Repositories\UserRepo;

class CourseController extends Controller
{

    public function index(CourseRepo $courseRepo)
    {
        $this->authorize('index', Course::class);
        if (auth()->user()->hasAnyPermission([Permission::PERMISSION_MANAGE_COURSES, Permission::PERMISSION_SUPER_ADMIN])) {
            $courses = $courseRepo->paginate();
        } else {
            $courses = $courseRepo->getCouresesByTeacherId(auth()->id());
        }
        return view('Courses::index', compact('courses'));
    }

    public function create(UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $this->authorize('create', Course::class);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();
        return view('Courses::create', compact('teachers', 'categories'));
    }

    public function store(CourseRequest $request, CourseRepo $courseRepo)
    {

        $request->request->add(['banner_id' => MediaFileServiece::publicUpload($request->file('image'))->id]);
        $courseRepo->store($request);
        return redirect()->route('courses.index');
    }

    public function edit($id, CourseRepo $courseRepo, UserRepo $userRepo, CategoryRepo $categoryRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('edit', $course);
        $teachers = $userRepo->getTeachers();
        $categories = $categoryRepo->all();

        return view('Courses::edit', compact('course', 'teachers', 'categories'));

    }

    public function update($id, CourseRequest $request, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('edit', $course);
        if ($request->hasFile('image')) {
            $request->request->add(['banner_id' => MediaFileServiece::publicUpload($request->file('image'))->id]);
            if ($course->banner)
                $course->banner->delete();
        } else {
            $request->request->add(['banner_id' => $course->banner_id]);

        }
        $courseRepo->update($id, $request);

        return redirect(route('courses.index'));
    }

    public function details($id, CourseRepo $courseRepo, LessonRepo $lessonRepo)
    {
        $course = $courseRepo->findById($id);
        $lessons = $lessonRepo->paginate($id);
        $this->authorize('details', $course);
        return view('Courses::details', compact('course', 'lessons'));
    }

    public function downloadLinks($id,CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize("download",$course);

        return implode("<br>", $course->downloadLinks())   ;

    }

    public function destroy($id, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($id);
        $this->authorize('delete', $course);
        if ($course->banner) {
            $course->banner->delete();
        }

        $course->delete();

        return AjaxResponses::successResponses();

    }

    public function accept($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_ACCEPTED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::FailedResponse();

    }

    public function reject($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateConfirmationStatus($id, Course::CONFIRMATION_STATUS_REJECTED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::FailedResponse();

    }

    public function lock($id, CourseRepo $courseRepo)
    {
        $this->authorize('change_confirmation_status', Course::class);
        if ($courseRepo->updateStatus($id, Course::STATUS_LOCKED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::FailedResponse();

    }

    public function buy($courseId, CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($courseId);



        if (!$this->courseCanBePruchased($course)) {
            return back();
        }

        if (!$this->authUserCanPurchaseCourse($course)) {
            return back();
        }

        $amount = $course->getFormattedFinalPrice();

        if ($amount <= 0){
            $courseRepo->addStudentToCourse($course,auth()->id());
            newFeedback("عملیات موفقیت","شما با موفقیت در دوره ثبت نام کردید.");
            return redirect($course->path());
        }

//        $payment = PaymentServices::generate($amount,$course,auth()->user());

         $payment = PaymentServices::createPay($amount,$course,auth()->user());


//        resolve(Gateway::class)->redirect($payment->invoice_id);

    }

    private function courseCanBePruchased($course)
    {
        if ($course->type == Course::TYPE_FREE) {
            newFeedback('عملیات ناموفق', 'دوره های رایگان قابل خدیداری نیستند!', "eror");
            return false;
        }
        if ($course->status == Course::STATUS_LOCKED) {
            newFeedback('عملیات ناموفق', 'این دوره قفل شده و فعلا قابل خریداری نیست!', "eror");
            return false;
        }
        if ($course->confirmation_status != Course::CONFIRMATION_STATUS_ACCEPTED) {
            newFeedback('عملیات ناموفق', 'دوره انتخابی شما هنوز تایید نشده است!', "eror");
            return false;
        }


        return true;
    }

    private function authUserCanPurchaseCourse($course)
    {
        if (auth()->id() == $course->teacher_id) {
            newFeedback('عملیات ناموفق', 'شما مدرس این دوره هستید!', "eror");
            return false;
        }
        if (auth()->user()->can('download',$course)) {
            newFeedback('عملیات ناموفق', 'شما این دوره را قبلا خریده اید!', "eror");
            return false;
        }
        return true;
    }


}
