@extends('reader.layouts.app')
@section('title')
    Shelves
@endsection
@section('content')
    <main class="container-xl mt-3">
        <div class="row row-cols-3 row-cols-md-4 row-cols-xl-5 g-4 mb-4">
            @foreach($shelves as $shelf)
                <div class="col">
                    @include('reader.shelf.shelf')
                </div>
            @endforeach
        </div>
{{--        <div class="mb-3">{{ $shelves->links() }}</div>--}}
    </main>
@endsection
