<?php


namespace Sadegh\Course\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Sadegh\Course\Rules\ValidSeason;
use Sadegh\Media\Services\MediaFileServiece;


class LessonRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        $rules =  [
            "title" => "required|min:3|max:190",
            "slug" => "nullable|min:3|max:190",
            "number" => "nullable|numeric",
            "time" => "required|numeric|min:0|max:255",
            "season_id" => [new ValidSeason()],
            "is_free" => "required|boolean",
            "lesson_file" => "required|file|mimes:avi,mkv,mp4,zip,rar"
        ];

        if (request()->method === "PATCH"){
            $rules['lesson_file'] = "nullable|file|mimes:".MediaFileServiece::getExtensions();
        }
        return $rules;
    }



    public function attributes()
    {
        return [
            "title" => "عنوان درس" ,
            "slug" => "عنوان انگلیسی درس",
            "number" => "شماره درس",
            "time" => "مدت زمان درس",
            "season_id" => "سرفصل",
            "free" => "رایگان",
            "lesson_file" => "فایل درس",
            "body" => " توضیحات درس",


        ];

    }

    public function messages()
    {
        return [
//            "price.min" => trans("Courses::validation.price_min"),
//            "price.max" => trans("Courses::validation.price_max"),
//            "price.required" => trans("Courses::validation.price_required"),
        ];
    }

}