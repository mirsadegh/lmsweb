<?php

namespace Sadegh\Course\Models;


use Illuminate\Database\Eloquent\Model;
use Sadegh\Category\Models\Category;
use Sadegh\Course\Repositories\CourseRepo;
use Sadegh\Media\Models\Media;
use Sadegh\Payment\Models\Payment;
use Sadegh\User\Models\User;

/**
 * @property mixed confirmationStatuses
 */
class Course extends Model
{

    protected $guarded = [];
    const TYPE_FREE = 'free';
    const TYPE_CASH = 'cash';
    static $types = [self::TYPE_FREE, self::TYPE_CASH];

    const STATUS_COMPLETED = 'completed';
    const STATUS_NOT_COMPLETED = 'not-completed';
    const STATUS_LOCKED = 'locked';
    static $statuses = [self::STATUS_COMPLETED, self::STATUS_NOT_COMPLETED, self::STATUS_LOCKED];

    const CONFIRMATION_STATUS_ACCEPTED = 'accepted';
    const CONFIRMATION_STATUS_REJECTED = 'rejected';
    const CONFIRMATION_STATUS_PENDING = 'pending';
    static $confirmationStatuses = [self::CONFIRMATION_STATUS_ACCEPTED , self::CONFIRMATION_STATUS_PENDING,self::CONFIRMATION_STATUS_REJECTED];



    public function banner()
    {
        return $this->belongsTo(Media::class, 'banner_id');
    }

    public function teacher()
    {
        return $this->belongsTo(User::class,'teacher_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class,'course_user','course_id','user_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seasons()

    {
        return $this->hasMany(Season::class);

    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function payments()
    {
        return $this->morphMany(Payment::class,"paymentable");
    }

    public function getDuration()
    {
        return (new CourseRepo())->getDuration($this->id);
    }

    public function hasStudent($student_id)
    {
       return resolve(CourseRepo::class)->hasStudent($this,$student_id);
    }

    public function formattedDuration()
    {
        $duration = $this->getDuration();
        $h = floor($duration / 60) <10 ? '0'.round($duration / 60): floor($duration / 60);
        $m = ($duration % 60 ) <10 ? '0'. ($duration % 60 ) : ($duration % 60 );
        return $h . ':' . $m . ":00";
    }


    public function getFormattedPrice()
    {
        return number_format($this->price);
    }
    public function getDiscountPercent()
    {
        //todo
        return 0;
    }
    public function getDiscountAmount()
    {
        //todo
        return 0;
    }
    public function getFinalPrice()
    {
        return $this->price - $this->getDiscountAmount();
    }
    public function getFormattedFinalPrice()
    {
        return number_format($this->getFinalPrice());
    }

    public function path()
    {
        return route('singleCourse',$this->id . '-'. $this->slug);
    }

    public function lessonsCount()
    {
        return (new CourseRepo())->getLessonsCount($this->id);
    }

    public function shortUrl()
    {
        return route('singleCourse', $this->id );
    }

    public function downloadLinks() :array
    {
        $links = [];
        foreach (resolve(CourseRepo::class)->getLessons($this->id) as $lesson){
            $links[] = $lesson->downloadLink();
        }
        return $links;
    }

}
