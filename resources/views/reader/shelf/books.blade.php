@extends('reader.layouts.app')
@section('title')
    Books
@endsection
@section('content')
    <main class="container-xl mt-3">
        <div class="row row-cols-3 row-cols-md-4 row-cols-xl-5 g-4 mb-4">
            @foreach($books as $book)
                <div class="col">
                    @include('reader.app.book')
                </div>
            @endforeach
        </div>
        <div class="mb-3">{{ $books->links() }}</div>
    </main>
@endsection
