@extends('reader.layouts.app')
@section('title')
    Home
@endsection
@section('content')
    <div class="container-xl py-4">
        <div class="row g-4 mb-4">
            <div class="col-sm-4 col-lg-3 col-xxl-2">
                @include('reader.app.filter')
            </div>
            <div class="col">
                <div class="row row-cols-3 row-cols-md-4 row-cols-xl-5 g-4 mb-4">
                    @foreach($books as $book)
                        <div class="col">
                            @include('reader.app.book')
                        </div>
                    @endforeach
                </div>
                {{ $books->links() }}
            </div>
        </div>
    </div>
@endsection