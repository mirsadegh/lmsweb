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
           'number' => $values->number,
           'season_id' => $values->season_id,
           'media_id' => $values->media_id,
           'course_id' => $courseId,
           'user_id' => auth()->id(),
           'body' => $values->body,
           'confirmation_status' => Lesson::CONFIRMATION_STATUS_PENDING,
           "status" => Lesson::STATUS_OPENED
       ]);
    }

    public function paginate()
    {
        return Lesson::orderBy('number')->paginate();
    }

    public function findById($id)
    {
        return Lesson::findOrFail($id);
    }

    public function update($id, $values)
    {
        return Lesson::where('id',$id)->update([
            'teacher_id' => $values->teacher_id,
            'category_id' => $values->category_id,
            'banner_id' => $values->banner_id,
            'title' => $values->title,
            'slug' => \Str::slug($values->slug),
            'number' => $this->generateNumber($id,$values->number),
            'price' => $values->price,
            'percent' => $values->percent,
            'type' => $values->type,
            'status' => $values->status,
            'body' => $values->body,
        ]);
    }

    public function updateConfirmationStatus($id,$status)
    {
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


}