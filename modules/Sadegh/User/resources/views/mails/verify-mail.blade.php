@component('mail::message')
# کد فعال سازی حساب شما در وب آموز

این ایمیل به دلیل ثبت نام شما در سایت وب آموز برای شما ارسال شده است .**در صورتی که ثبت نامی توسط شما انجام نشده است** این ایمیل را نادیده بگیرید.

@component('mail::panel')
      کد فعالسازی شما :         {{$code}}
@endcomponent
با تشکر.<br>
{{ config('app.name') }}
@endcomponent


