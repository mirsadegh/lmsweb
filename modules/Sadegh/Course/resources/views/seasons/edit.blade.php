@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('courses.details',$season->course_id) }}" title="سرفصل">سرفصل</a></li>
    <li><a href="#" title="ویرایش">ویرایش سرفصل</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
<p class="box__title">بروزرسانی سرفصل جدید</p>
            <form action="{{ route('seasons.update',$season->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')

                <x-input type="text" name="title" placeholder="عنوان سرفصل" class="text" value="{{ $season->title }}" required />
                <x-input type="text" name="number" placeholder="شماره سرفصل" class="text" value="{{ $season->number }}" />

                <br>
                <button class="btn btn-webamooz_net">بروزرسانی سرفصل</button>
            </form>
        </div>
    </div>
@endsection


