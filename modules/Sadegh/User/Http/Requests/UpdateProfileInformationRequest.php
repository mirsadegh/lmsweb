<?php


namespace Sadegh\User\Http\Requests;


use Illuminate\Foundation\Http\FormRequest;
use Sadegh\RolePermissions\Models\Permission;
use Sadegh\User\Rules\ValidPassword;

class UpdateProfileInformationRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  auth()->check() == true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [

            "name" => "required|min:3|max:190",
            "email" => "required|email|min:3|max:190|unique:users,email,".auth()->id(),
            "username" => "nullable|min:3|max:190|unique:users,username,".auth()->id(),
            "mobile" => "nullable|unique:users,mobile,".request()->route('user'),
            'password' => ['nullable',new ValidPassword()]
        ];

        if (auth()->user()->hasPermissionTo(Permission::PERMISSION_TEACH)){

            $rules += [
                "card_number" => "required|string|size:16",
                "shaba" => "required|size:24",
                "headline" => "required|min:3|max:60",
                "bio" => "required",
            ];
            $rules['username'] = "required|min:3|max:190|unique:users,username,".auth()->id();

        }

        return $rules;
    }

    public function attributes()
    {


        return [
            "shaba" => 'شماره شبا بانکی',
            'card_number' => 'شماره کارت بانکی',
            'username' => 'شماره کاربری',
            'headline' => 'عنوان',
            'bio' => 'بیو',
            'password' => 'رمز عبور جدید',
            'mobile' => 'موبایل'
        ];
    }

}