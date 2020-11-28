@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('users.index') }}" title="پروفایل">پروفایل</a></li>
    <li><a href="#" title="ویرایش">ویرایش</a></li>
@endsection

@section('content')
    <div class="row no-gutters margin-bottom-20">
        <div class="col-12 bg-white">
<p class="box__title">بروزرسانی پروفایل جدید</p>
            <x-user-photo />
            <form action="{{ route('users.profile') }}" class="padding-30" method="post">
                @csrf
                <x-input name="name" placeholder="نام "  type="text" value="{{ auth()->user()->name }}" />
                <x-input name="email" placeholder="ایمیل" type="email" class="text-left" required value="{{ auth()->user()->email }}" />
                <x-input name="mobile" placeholder="موبایل" type="text" class="text-left"  value="{{ auth()->user()->mobile }}" />
                <x-input name="password" placeholder="پسورد جدید" type="password" value="" />
                <p class="rules">رمز عبور باید حداقل ۶ کاراکتر و ترکیبی از حروف بزرگ، حروف کوچک، اعداد و کاراکترهای
                    غیر الفبا مانند <strong>!@#$%^&amp;*()</strong> باشد.</p>


                @can(\Sadegh\RolePermissions\Models\Permission::PERMISSION_TEACH)
                <x-input name="card_number" placeholder="شماره کارت بانکی" type="text" class="text-left"  value="{{ auth()->user()->card_number }}" />
                <x-input name="shaba" placeholder="شماره شبا بانکی" type="text" class="text-left"  value="{{ auth()->user()->shaba }}" />
                <x-input name="username" placeholder="نام کاربری و آدرس پروفایل" type="text" class="text-left" value="{{ auth()->user()->username }}" />

                <p class="input-help text-left margin-bottom-12" dir="ltr">

                    <a href="{{auth()->user()->profilePath() }}">{{ auth()->user()->profilePath() }}</a>
                </p>
                <x-input name="headline" placeholder="عنوان" type="text"   value="{{ auth()->user()->headline }}" />
                <x-textarea placeholder="بیو" name="bio" value="{{ auth()->user()->bio  }}"  />
                @endcan
                <br>
                <button class="btn btn-webamooz_net">بروزرسانی پروفایل</button>
            </form>



        </div>
    </div>

@endsection


@section('js')
    <script src="/panel/js/tagsInput.js?v={{ uniqid() }}"></script>
    <script>
        @include('Common::layouts.feedbacks')
    </script>
@endsection


