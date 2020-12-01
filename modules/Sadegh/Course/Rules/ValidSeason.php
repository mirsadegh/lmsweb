<?php


namespace Sadegh\Course\Rules;


use Illuminate\Contracts\Validation\Rule;
use Sadegh\Course\Repositories\SeasonRepo;
use Sadegh\User\Repositories\UserRepo;

class ValidSeason implements Rule
{


    public function passes($attribute, $value)
    {
        $season = resolve(SeasonRepo::class)->findByIdandCourseId($value,request()->route('course'));
        if ($season){
            return true;
        }
        return false;
    }


    public function message()
    {
        return "سرفصل انتخاب شده معتبر نمیباشد.";
    }
}