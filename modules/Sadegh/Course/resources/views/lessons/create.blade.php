@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="دوره ها">دوره ها</a></li>
    <li><a href="{{ route('courses.details',$course->id) }}" title="{{ $course->title }}">{{ $course->title }}</a></li>
    <li><a href="#" title="ایجاد">ایجاد درس</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
<p class="box__title">ایجاد درس جدید</p>
            <form action="{{ route('lessons.store',$course->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf

                <x-input name="title" placeholder="عنوان درس *" type="text" required />
                <x-input name="slug" placeholder="نام انگلیسی درس اختیاری" type="text" class="text-left" />
                <x-input name="time" placeholder="مدت زمان جلسه *" type="number" class="text-left" required />
                <x-input name="number" placeholder="شماره جلسه" type="number" class="text-left"/>


                @if(count($seasons))
                <x-select name="season_id" required>
                    <option value=""> انتخاب سرفصل درس *</option>
                    @foreach($seasons as $season)
                    <option value="{{ $season->id }}" @if($season->id == old('season_id')) selected @endif>
                        {{ $season->title }}
                    </option>
                    @endforeach
                </x-select>
                @endif


                <div class="w-50">
                    <p class="box__title">ایا این درس رایگان است ؟ </p>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-1" name="free" value="0" type="radio" checked="">
                        <label for="lesson-upload-field-1">خیر</label>
                    </div>
                    <div class="notificationGroup">
                        <input id="lesson-upload-field-2" name="free" value="1" type="radio">
                        <label for="lesson-upload-field-2">بله</label>
                    </div>
                </div>

                <x-file placeholder="آپلود درس *" name="lesson_file" required />
                <x-textarea placeholder="توضیحات درس" name="body"/>
                <br>
                <button class="btn btn-webamooz_net">ایجاد درس</button>
            </form>
        </div>
    </div>
@endsection



