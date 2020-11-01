<?php

namespace Sadegh\User\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Sadegh\User\Services\VerifyCodeService;

class VerifyCodeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'verify_code' => VerifyCodeService::getRule()
        ];
    }
}
