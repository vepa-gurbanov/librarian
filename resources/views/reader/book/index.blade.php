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
            <div class="col overflow-y-scroll" style="height: 100vh">
                <div class="mb-3 border-bottom small">
                    Results found: <span class="fw-semibold">{{ $books->total() }}</span>
                </div>
                <div class="row row-cols-sm-1 row-cols-2 row-cols-md-3 row-cols-xl-4 g-4 mb-4">
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
