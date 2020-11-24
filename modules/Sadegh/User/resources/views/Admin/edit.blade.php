@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('users.index') }}" title="کاربر">کاربر</a></li>
    <li><a href="#" title="ویرایش">ویرایش</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
<p class="box__title">بروزرسانی کاربر جدید</p>
            <form action="{{ route('users.update',$user->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <x-input name="name" placeholder="نام "  type="text" value="{{ $user->name }}" />
                <x-input name="email" placeholder="ایمیل" type="email" class="text-left" required value="{{ $user->email }}" />
                <x-input name="username" placeholder="نام کاربری" type="text" class="text-left" value="{{ $user->username }}" />
                <x-input name="mobile" placeholder="موبایل" type="text" class="text-left"  value="{{ $user->mobile }}" />
                <x-input name="headline" placeholder="عنوان" type="text" class="text-left"  value="{{ $user->headline }}" />
                <x-input name="website" placeholder="وب سایت" type="text" class="text-left"  value="{{ $user->website }}" />
                <x-input name="linkedin" placeholder="لینکداین" type="text" class="text-left"  value="{{ $user->linkedin }}" />
                <x-input name="facebook" placeholder="فیسبوک" type="text" class="text-left"  value="{{ $user->facebook }}" />
                <x-input name="twitter" placeholder="تویتر" type="text" class="text-left"  value="{{ $user->twitter }}" />
                <x-input name="youtube" placeholder="یوتیوب" type="text" class="text-left" value="{{ $user->youtube }}" />
                <x-input name="instagram" placeholder="اینستگرام" type="text" class="text-left"  value="{{ $user->instagram }}" />
                <x-input name="telegram" placeholder="تلگرام" type="text" class="text-left"  value="{{ $user->telegram }}" />

                <x-select name="status" required>
                    <option value="">وضعیت حساب </option>
                    @foreach(\Sadegh\User\Models\User::$statuses as $status)
                        <option value="{{ $status }}" @if($status == old('status',$user->$status)) selected @endif>
                            @lang($status)
                        </option>
                    @endforeach
                </x-select>

                <x-file placeholder="آپلود بنر کاربر" name="image" :value="$user->image" />
                <x-input name="password" placeholder="پسورد جدید" type="password" value="" />

                <x-textarea placeholder="بیو" name="bio" value="{{ $user->bio  }}"  />
                <br>
                <button class="btn btn-webamooz_net">بروزرسانی کاربر</button>
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


