<?php

namespace Sadegh\Course\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sadegh\Common\Responses\AjaxResponses;
use Sadegh\Course\Http\Requests\LessonRequest;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Models\Lesson;
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

    public function create($courseId, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {
        $seasons = $seasonRepo->getCourseSeason($courseId);
        $course = $courseRepo->findById($courseId);
        $this->authorize('createLesson',$course);
        return view('Courses::lessons.create', compact('seasons', 'course'));
    }

    public function store($courseId, LessonRequest $request,CourseRepo $courseRepo)
    {
        $course = $courseRepo->findById($courseId);
        $this->authorize('createLesson',$course);
        $request->request->add(["media_id" => MediaFileServiece::privateUpload($request->file('lesson_file'))->id]);
        $this->lessonRepo->store($courseId, $request);
        newFeedback();
        return redirect(route('courses.details', $course));

    }

    public function edit($courseId, $lessonId, SeasonRepo $seasonRepo, CourseRepo $courseRepo)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        $this->authorize('edit',$lesson);
        $seasons = $seasonRepo->getCourseSeason($courseId);
        $course = $courseRepo->findById($courseId);
        return view('Courses::lessons.edit', compact('lesson', 'seasons', 'course'));

    }

    public function update($courseId, $lessonId, LessonRequest $request)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        $this->authorize('edit',$lesson);
        if ($request->hasFile('lesson_file')) {
            if ($lesson->media)
                $lesson->media->delete();
            $request->request->add(["media_id" => MediaFileServiece::privateUpload($request->file('lesson_file'))->id]);

        } else {
            $request->request->add(["media_id" => $lesson->media->id]);
        }
        $this->lessonRepo->update($lessonId, $courseId, $request);
        newFeedback();
        return redirect(route('courses.details', $courseId));

    }

    public function accept($id)
    {
        $this->authorize('manage',Course::class);
        $this->lessonRepo->updateConfirmationStatus($id, Lesson::CONFIRMATION_STATUS_ACCEPTED);
        return AjaxResponses::successResponses();
    }

    public function acceptAll($courseId)
    {
        $this->authorize('manage',Course::class);
        $this->lessonRepo->acceptAll($courseId);
        newFeedback();
        return back();

    }

    public function acceptMultiple(Request $request)
    {
        $this->authorize('manage',Course::class);
         $ids = explode(',',$request->ids);
         $this->lessonRepo->updateConfirmationStatus($ids,Lesson::CONFIRMATION_STATUS_ACCEPTED);
         newFeedback();
         return back();
    }

    public function rejectMultiple(Request $request)
    {
        $this->authorize('manage',Course::class);
        $this->authorize('manage',Course::class);
         $ids = explode(',',$request->ids);
         $this->lessonRepo->updateConfirmationStatus($ids,Lesson::CONFIRMATION_STATUS_REJECTED);
         newFeedback();
         return back();
    }




    public function reject($id)
    {
        $this->authorize('manage',Course::class);
        $this->lessonRepo->updateConfirmationStatus($id, Lesson::CONFIRMATION_STATUS_REJECTED);
        return AjaxResponses::successResponses();
    }

    public function lock($id)
    {
        $this->authorize('manage',Course::class);
        if ($this->lessonRepo->updateStatus($id, Lesson::STATUS_LOCKED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::FailedResponse();

    }

    public function unlock($id)
    {
        $this->authorize('manage',Course::class);
        if ($this->lessonRepo->updateStatus($id, Lesson::STATUS_OPENED)) {
            return AjaxResponses::successResponses();
        }
        return AjaxResponses::FailedResponse();

    }


    public function destroy($courseId, $lessonId)
    {
        $lesson = $this->lessonRepo->findById($lessonId);
        $this->authorize('delete',$lesson);

        if ($lesson->media) {
            $lesson->media->delete();
        }

        $lesson->delete();
        return AjaxResponses::successResponses();
    }

    public function destroyMultiple(Request $request)
    {
        $ids = explode(',', $request->ids);
        foreach ($ids as $id) {
            $lesson = $this->lessonRepo->findById($id);
            $this->authorize('delete',$lesson);
            if ($lesson->media) {
                $lesson->media->delete();
            }

            $lesson->delete();
        }
        newFeedback();
        return back();
    }
}