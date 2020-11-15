<?php
/**
 * Created by PhpStorm.
 * User: Home
 * Date: 11/11/2020
 * Time: 9:44 PM
 */

namespace Sadegh\Course\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Sadegh\Course\Models\Course;
use Sadegh\Course\Rules\ValidTeacher;

class CourseRequest extends FormRequest
{

    public function authorize()
    {
        return auth()->check() == true;
    }

    public function rules()
    {
        return [
            "title" => "required|min:3|max:190",
            "slug" => "required|min:3|max:190|unique:courses,slug",
            "priority" => "nullable|numeric",
            "price" => "required|numeric|min:0|max:10000000",
            "percent" => "required|numeric|min:0|max:100",
            "teacher_id" => ["required", "exists:users,id", new ValidTeacher()],
            "type" => ["required", Rule::in(Course::$types)],
            "status" => ["required", Rule::in(Course::$statuses)],
            "category_id" => "required|exists:categories,id",
            "image" => "required|mimes:jpg,png,jpeg"
        ];
    }

    public function attributes()
    {
        return [
            "price" => "قیمت" ,
            "slug" => "عنوان انگلیسی",
            "priority" => "ردیف دوره",
            "percent" => "درصد مدرس",
            "teacher_id" => "مدرس",
            "category_id" => "دسته بندی",
            "status" => "وضیعت",
            "type" => "نوع",
            "body" => "توضیحات",
            "image" => "بنر دوره",

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