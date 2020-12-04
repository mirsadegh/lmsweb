<?php


namespace Sadegh\Course\Repositories;


use Sadegh\Common\Responses\AjaxResponses;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Models\Lesson;

class LessonRepo
{
    public function store($courseId,$values)
    {
       return Lesson::create([
           'title' => $values->title,
           'slug' =>  $values->slug ?  \Str::slug($values->slug):\Str::slug($values->title),
           'time' => $values->time,
           'number' => $this->generateNumber($courseId,$values->number),
           'season_id' => $values->season_id,
           'media_id' => $values->media_id,
           'course_id' => $courseId,
           'user_id' => auth()->id(),
           'body' => $values->body,
           'confirmation_status' => Lesson::CONFIRMATION_STATUS_PENDING,
           "status" => Lesson::STATUS_OPENED,
           "is_free" => $values->is_free
       ]);
    }

    public function paginate($courseId)
    {
        return Lesson::where('course_id',$courseId)->orderBy('number')->paginate();
    }

    public function findById($id)
    {
        return Lesson::findOrFail($id);
    }

    public function update($id,$courseId, $values)
    {
        return Lesson::where('id',$id)->update([
            'title' => $values->title,
            'slug' =>  $values->slug ?  \Str::slug($values->slug):\Str::slug($values->title),
            'time' => $values->time,
            'number' => $this->generateNumber($courseId,$values->number),
            'season_id' => $values->season_id,
            'media_id' => $values->media_id,
            'body' => $values->body,
            "is_free" => $values->is_free
        ]);
    }

    public function updateConfirmationStatus($id,$status)
    {
        if (is_array($id)){
            return Lesson::query()->whereIn('id',$id)->update(['confirmation_status'=>$status]);
        }
       return Lesson::where('id',$id)->update(['confirmation_status' => $status]);
    }

    public function updateStatus($id, $status)
    {
        return Lesson::where('id',$id)->update(['status' => $status]);
    }

    protected function generateNumber($course_id, $number)
    {
        $courseRepo = new CourseRepo();
        if (is_null($number)) {
            $number = $courseRepo->findById($course_id)->lessons()->orderBy('number', 'desc')->firstOrNew([])->number ?: 0;
            $number++;
        }
        return $number;
    }

    public function acceptAll($courseId)
    {
        return Lesson::where('course_id',$courseId)->update(['confirmation_status'=>Lesson::CONFIRMATION_STATUS_ACCEPTED]);
    }




}