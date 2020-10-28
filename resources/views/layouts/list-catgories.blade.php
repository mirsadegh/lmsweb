<ul>
    @foreach($categories as $category)
    <li>{{ $category->name }}</li>
        @if($category->child)
         @include('layouts.list-catgories',['categories' => $category->child])
        @endif
     @endforeach
</ul>