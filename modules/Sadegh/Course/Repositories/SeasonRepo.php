<?php


namespace Sadegh\Course\Repositories;


use Sadegh\Common\Responses\AjaxResponses;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Models\Season;

class SeasonRepo
{
    public function getCourseSeason($course)
    {
        return Season::where('course_id',$course)
            ->where('confirmation_status',Season::CONFIRMATION_STATUS_ACCEPTED)
            ->orderBy('number')->get();
    }

    public function findByIdandCourseId($seasonId,$courseId)
    {
       return Season::where('course_id',$courseId)->where('id',$seasonId)->first();
    }

    public function store($id,$values)
    {
        return Season::create([
           'course_id' => $id,
           'user_id' => auth()->id(),
           'title' => $values->title,
           'number' =>  $this->generateNumber($id, $values->number),
           'confirmation_status' => Season::CONFIRMATION_STATUS_PENDING,
            'status' => Season::STATUS_OPENED,
       ]);
    }



    public function findById($id)
    {
        return Season::findOrFail($id);
    }

    public function update($id, $values)
    {
        return Season::where('id',$id)->update([
            'title' => $values->title,
            'number' => $this->generateNumber($id, $values->number),
        ]);
    }

    public function updateConfirmationStatus($id,$status)
    {
       return Season::where('id',$id)->update(['confirmation_status' => $status]);
    }

    public function updateStatus($id, $status)
    {
        return Season::where('id',$id)->update(['status' => $status]);
    }


    protected function generateNumber($course_id, $number)
    {
        $courseRepo = new CourseRepo();
        if (is_null($number)) {
            $number = $courseRepo->findById($course_id)->seasons()->orderBy('number', 'desc')->firstOrNew([])->number ?: 0;
            $number++;
        }
        return $number;
    }


}