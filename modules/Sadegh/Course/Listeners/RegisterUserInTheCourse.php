<?php

namespace Sadegh\Course\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Repositories\CourseRepo;

class RegisterUserInTheCourse
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        if($event->payment->paymentable_type == Course::class){
            resolve(CourseRepo::class)->addStudentToCourse($event->payment->paymentable,$event->payment->buyer_id);
        }
    }
}
