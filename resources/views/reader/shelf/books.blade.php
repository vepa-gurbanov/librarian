@extends('reader.layouts.app')
@section('title')
    Books
@endsection
@section('content')
    <main class="container-xl mt-3">
        <div class="row row-cols-4 row-cols-md-5 row-cols-xl-6 g-4 mb-4">
            @foreach($books as $book)
                <div class="col">
                    @include('reader.app.book')
                </div>
            @endforeach
            <div class="mb-3">{{ $books->links() }}</div>
        </div>
    </main>
@endsection
