@extends('reader.layouts.app')
@section('title')
    {{ $book->name }}
@endsection
@section('content')
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
    <main class="container-xl mt-3">
        <div class="bg-secondary-subtle rounded">
            <div class="d-flex justify-content-between">
                <div class="col-3 border-end p-4">
                    <div class="rounded mb-3">
                        <img src="{{ $book->image() }}" alt="{{ $book->name }}" class="img-fluid rounded">
                    </div>
                    <div class="d-flex justify-content-between overflow-hidden mb-3">
                        <div class="col-auto me-2">
                            <button type="button" class="btn btn-light bi-stickies"><br><span class="text-center">Notes</span></button>
                        </div>
                        <div class="col-auto me-2">
                            <button type="button" class="btn btn-light bi-chat-square-text"><br><span class="text-center">Review</span></button>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-light bi-share"><br><span class="text-center">Share</span></button>
                        </div>
                    </div>
                    <div class="mb-3 d-flex justify-content-center border-bottom align-items-center">
                        <div class="col-auto bg-white rounded p-2 text-center" style="width: 40px; height: 40px">{{ number_format($book->averageRating(), '1') }}</div>
                        <div class="col-auto rate">
                            <input type="hidden" name="bookID" value="{{ $book->id }}">
                            @foreach(range(5,1) as $number)
                                <input type="radio" id="{{ $number }}" name="rate" value="{{ $number }}"
                                    {{ intval($book->rating(auth('reader')->id())) === $number ? 'checked' : '' }} />
                                <label for="{{ $number }}" title="text">{{ $number . ' ' . $number !== 1 ? 'stars' : 'star' }}</label>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col p-4">
                    <div class="h2 fw-bold" style="font-family: Georgia,'Palatino Linotype','Book Antiqua',Palatino,serif;">{{ $book->name }}</div>
                    <div class="h6">
                        <span class="fst-italic">by</span>
                        @foreach($book->authors as $author)
                            <a href="{{ route('books.index', ['au' => [[$author->id]]]) }}">{{ $author->name }}</a> {{ !$loop->last ? ', ': '' }}
                        @endforeach
                        <span class="fst-italic">( {{ date_format($book->published_at, 'Y') }}
                            @if(!empty($book->publishedCountries()))
                                {{ implode(', ', $book->publishedCountries()) }}
                            @endif
                        <span>)</span>
                        </span>
                    </div>
                    <div class="my-3">
                        <span>
                            @foreach(range(1,5) as $rate)
                                <i class="bi-star{{ intval(round($book->averageRating())) >= $rate ? '-fill' : '' }} text-warning"></i>
                            @endforeach
                            {{ number_format($book->averageRating(), 1) }}
                        </span> ●
                        <span>
                            {{ $book->totalRatings() }} ratings total
                        </span> ●
                        <span>
                            {{ $book->ratedReaders->count() }} {{ $book->ratedReaders->count() > 1 ? 'users' : 'user' }}  rated
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection



