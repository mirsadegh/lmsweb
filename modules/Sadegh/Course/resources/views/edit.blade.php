@extends('Dashboard::master')

@section('breadcrumb')
    <li><a href="{{ route('courses.index') }}" title="دوره">دوره</a></li>
    <li><a href="#" title="ویرایش">ویرایش</a></li>
@endsection

@section('content')
    <div class="row no-gutters">
        <div class="col-12 bg-white">
<p class="box__title">بروزرسانی دوره جدید</p>
            <form action="{{ route('courses.update',$course->id) }}" class="padding-30" method="post" enctype="multipart/form-data">
                @csrf
                @method('patch')
                <x-input name="title" placeholder="عنوان دوره" type="text" required value="{{ $course->title }}" />
                <x-input name="slug" placeholder="نام انگلیسی دوره" type="text" class="text-left" required value="{{ $course->slug }}" />


                <div class="d-flex multi-text">
                    <x-input type="text" class="text-left mlg-15" value="{{ $course->priority }}" name="priority" placeholder="ردیف دوره" />
                    <x-input type="text" placeholder="مبلغ دوره" value="{{ $course->price }}" name="price" class="text-left" />
                    <x-input type="number" placeholder="درصد مدرس" value="{{ $course->percent }}" name="percent" class="text-left text" required />
                </div>
                <x-select name="teacher_id" required>
                    <option value="">انتخاب مدرس دوره</option>
                    @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}" @if($teacher->id == old('teacher_id',$course->teacher->id)) selected @endif>
                        {{ $teacher->name }}
                    </option>
                    @endforeach
                </x-select>

                <x-tag-select name="tags" />

                <x-select name="type" required>
                    <option value="">نوع دوره</option>
                    @foreach(\Sadegh\Course\Models\Course::$types as $type)
                        <option value="{{ $type }}" @if($type == old('type',$course->type)) selected @endif>
                            @lang($type)
                        </option>
                    @endforeach
                </x-select>

                <x-select name="status" required>
                    <option value="">وضعیت دوره</option>
                    @foreach(\Sadegh\Course\Models\Course::$statuses as $status)
                        <option value="{{ $status }}" @if($status == old('status',$course->status)  ) selected @endif>
                            @lang($status)
                        </option>
                    @endforeach

                </x-select>
                <x-select name="category_id" required>
                    <option value="">دسته بندی </option>
                    @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if($category->id == old('category_id',$course->category_id)) selected @endif>
                        {{ $category->title }}
                    </option>
                    @endforeach

                </x-select>

                <x-file placeholder="آپلود بنر دوره" name="image" :value="$course->banner" />



                <x-textarea placeholder="توضیحات دوره" name="body" value="{{ $course->body  }}"  />
                <br>
                <button class="btn btn-webamooz_net">بروزرسانی دوره</button>
            </form>
        </div>
    </div>
@endsection


@section('js')
    <script src="/panel/js/tagsInput.js?v={{ uniqid() }}"></script>
@endsection


