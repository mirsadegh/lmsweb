<?php

namespace Sadegh\User\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Sadegh\User\Http\Requests\ResetPasswordVerifyCodeRequest;
use Sadegh\User\Http\Requests\SendResetPasswordVerifyCodeRequest;
use Sadegh\User\Http\Requests\VerifyCodeRequest;
use Sadegh\User\Models\User;
use Sadegh\User\Repositories\UserRepo;
use Sadegh\User\Services\VerifyCodeService;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    public function showVerifyCodeRequestForm()
    {
        return view('User::Front.passwords.email');
    }

    public function sendVerifyCodeEmail(SendResetPasswordVerifyCodeRequest $request,UserRepo $userRepo)
    {
        $user = $userRepo->findByEmail($request->email);

//        if (!$user){
//            return back()->withErrors(['not_email' => 'با این ایمیل ثبت نشده است!']);
//        }
        if ($user && ! VerifyCodeService::has($user->id)) {
             $user->sendResetPasswordRequestNotification();
        }



        return view('User::Front.passwords.enter-verify-code-form');

    }

    public function checkVerifyCode(ResetPasswordVerifyCodeRequest $request)
    {

        $user = resolve(UserRepo::class)->findByEmail($request->email);

        if ($user ==null || ! VerifyCodeService::check($user->id, $request->verify_code)) {
            return back()->withErrors(['verify_code' => 'کد وارد شده معتبر نمیباشد!']);
        }

        auth()->loginUsingId($user->id);

        return redirect()->route('password.showResetForm');
    }


}
