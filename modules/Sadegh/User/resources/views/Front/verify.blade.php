@extends('User::Front.master')

@section('content')
<div class="form">

    <a class="account-logo" href="index.html">
        <img src="/img/weblogo.png" alt="">
    </a>

    <div class="form-content form-account">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                      یک لینک تایید ایمیل جدید ایمیل تان ارسال شده است.
            </div>
        @endif

                      قبل از اقدام ایمیل تان را چک کنید.
                    اگر ایمیلی دریافت نکردید درخواست ارسال مجدد لینک بدهید.
        <form class="d-inline center" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn btn-link p-0 m-0 align-baseline">ارسال مجدد کد لینک تایید.</button>.
            <a href="/" class="">بازگشت به صفحه اصلی</a>
        </form>
    </div>

    {{--<div class="row justify-content-center">--}}
        {{--<div class="col-md-8">--}}
            {{--<div class="card">--}}
                {{--<div class="card-header">{{ __('Verify Your Email Address') }}</div>--}}

                {{--<div class="card-body">--}}
                    {{--@if (session('resent'))--}}
                        {{--<div class="alert alert-success" role="alert">--}}
                            {{--{{ __('A fresh verification link has been sent to your email address.') }}--}}
                        {{--</div>--}}
                    {{--@endif--}}

                    {{--{{ __('Before proceeding, please check your email for a verification link.') }}--}}
                    {{--{{ __('If you did not receive the email') }},--}}
                    {{--<form class="d-inline" method="POST" action="{{ route('verification.resend') }}">--}}
                        {{--@csrf--}}
                        {{--<button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.--}}
                    {{--</form>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
</div>
@endsection
