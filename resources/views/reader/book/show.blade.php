@if(!isset($book)) {{ abort(404) }} @endif
@extends('reader.layouts.app')
@section('title')
    {{ $book->name }}
@endsection
@section('content')
    <link rel="stylesheet" href="{{ asset('css/rating.css') }}">
    <link rel="stylesheet" href="{{ asset('css/badge.css') }}">
    <main class="container-xl mt-3">
        <div class="bg-secondary-subtle rounded">
            <div class="d-flex justify-content-between">
                <div class="col-3 border-end p-4">
                    <div class="rounded mb-3">
                        <img src="{{ $book->image() }}" alt="{{ $book->name }}" class="img-fluid rounded">
                    </div>
                    <div class="d-flex justify-content-between overflow-hidden mb-3">
                        <div class="col-auto me-2">
                            <button type="button" data-bs-target="#bookNote{{ $book->id }}" data-bs-toggle="modal" class="btn btn-light bi-stickies">
                                <br><span class="text-center">Notes</span>
                            </button>

                            <div class="modal fade" id="bookNote{{ $book->id }}" tabindex="-1" aria-labelledby="bookNote{{ $book->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="{{ route('book.review.note', $book->slug) }}" method="POST">
                                                @method('POST')
                                                @csrf
                                                <textarea class="form-control bg-body-tertiary" name="note" id="bookNote{{ $book->id }}" cols="30" rows="10"></textarea>
                                                <div class="mt-3 text-end">
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-auto me-2">
                            <button type="button" data-bs-target="#bookReview{{ $book->id }}" data-bs-toggle="modal" class="btn btn-light bi-chat-square-text">
                                <br><span class="text-center">Review</span>
                            </button>

                            <div class="modal fade" id="bookReview{{ $book->id }}" tabindex="-1" aria-labelledby="bookReview{{ $book->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body">
                                            <form action="{{ route('book.review.note', $book->slug) }}" method="POST">
                                                @method('POST')
                                                @csrf
                                                <textarea class="form-control bg-body-tertiary" name="review" id="bookReview{{ $book->id }}" cols="30" rows="10"></textarea>
                                                <div class="mt-3 text-end">
                                                    <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-secondary btn-sm">Submit</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

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
                    <div class="mb-3">
                        <a href="#" class="btn btn-sm btn-primary w-100">
                            @lang('lang.rent-per-day'): {!! $book->priceFormat($book->price) !!}
                        </a>
                    </div>
                </div>
                <div class="col p-4">

                    @if($book->isNew())
                        <div class="badge be-polygon" style="background-color: green">
                            @lang('lang.new')
                        </div>
                    @endif

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
                        </span> ·
                        <span>
                            {{ $book->totalRatings() }} ratings total
                        </span> ·
                        <span>
                            {{ $book->ratedReaders->count() }} {{ $book->ratedReaders->count() > 1 ? 'users' : 'user' }}  rated
                        </span>
                    </div>
                    <div class="mb-3 small">
                        @foreach($book->attributeValues as $value)
                            <div>{{ $value->attribute->name . ': ' . $value->name }}</div>
                        @endforeach
                        <div>
                            {!! trans('lang.rent-per-day') . ': ' . $book->priceFormat('price') !!}

                            {{-- be-polygon === badge end polygon --}}
                            @if($book->isDiscount())
                                <div class="badge text-bg-danger be-polygon">
                                    -{{ $book->discount_percent }}% @lang('lang.off')
                                </div>
                            @endif

                        </div>
                        <div>{!! trans('lang.damaged-state-of-book') . ': ' . $book->priceFormat('value') !!}</div>
                        <div>{{ trans('lang.pages') . ': ' . $book->page }}</div>
                        <div>{{ trans('lang.written') . ': ' . date_format($book->written_at, 'F, Y') }}</div>
                        <div>{{ trans('lang.published') . ': ' . date_format($book->published_at, 'F, Y') }}</div>
                        <div>{{ trans('lang.viewed') . ': ' . $book->viewed }}</div>
                        <div>
                            @lang('lang.liked') :
                            <a href="javascript:void(0);" class="bi-hand-thumbs-up-fill {{ $liked }}" content="like"  id="{{ $book->id }}"></a>
                            <span id="book{{ $book->id }}">{{ $book->liked }}</span>
                        </div>
                        <div>{{ trans('lang.isbn') . ': ' . $book->book_code }}</div>
                    </div>
                    <div class="mb-3">
                        {{ $book->body }}
                    </div>
                    @if($book->options->count() > 0)
                        <div class="mb-3">
                            <p class="mb-1">Options:</p>

                            <div class="d-inline-flex justify-content-between">
                                @foreach($book->options as $option)
                                    <div class="col-auto w-100 card shadow rounded m-1 p-2 bg-body-secondary">
                                        <div class="small"><span>Type: </span>{{ $option->type }}</div>
                                        <div class="small"><span>Format: </span>{{ $option->format }}</div>
                                        <div class="small"><span>Volume: </span>{{ $option->volume }} mb</div>
                                        <div class="small"><span>Price: </span>{{ number_format($option->price, '2') }} <span class="small-sm">TMT</span></div>
                                        <a href="#" class="btn btn-sm btn-primary">Download {{ $option->type === 'electron' ? 'PDF' : strtoupper($option->type) }}</a>
                                    </div>
                                @endforeach
                            </div>
                            <div class="mb-3">
                                <a href="#" class="btn btn-outline-primary m-1">
                                    <span class="bi-gift-fill text-danger"></span>
                                    <span class="text-danger">Bundle:</span> {{ $book->options->sum('price') + $book->price }}
                                    <span class="small-sm">TMT</span>
                                </a>
                            </div>
                        </div>
                    @endif

                    @if($book->reviews->count() > 0)
                        <div class="mb-3">
                            <p class="mb-1">Reviews:</p>

                            @php $latest = $book->reviews->first(); @endphp
                            <div class="mb-3 border-bottom small">
                                <span>{{ $latest->reader->name }}</span>
                                <div class="ms-3">
                                    <p class="mb-1">- {{ $latest->review }}</p>
                                    <span class="small-sm">{{ date_format($latest->created_at, 'Y-m-d | H:i:s') }}</span>
                                </div>
                            </div>

                            @if($book->reviews->count() > 1)
                                <p class="d-inline-flex gap-1">
                                    <a data-bs-toggle="collapse" href="#collapseReview" role="button" aria-expanded="false" aria-controls="collapseReview">
                                        Show more
                                    </a>
                                </p>
                                <div class="collapse" id="collapseReview">
                                    <div class="card card-body bg-transparent border-0">
                                        @foreach($book->reviews as $review)
                                            @continue($loop->first)
                                            <div class="mb-3 border-bottom small">
                                                <span>{{ $review->reader->name }}</span>
                                                <div class="ms-3">
                                                    <p class="mb-1">- {{ $review->review }}</p>
                                                    <span class="small-sm">{{ date_format($review->created_at, 'Y-m-d | H:i:s') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif

                    @if($book->notes->count() > 0)
                        <div class="mb-3">
                            <p class="mb-1">My Notes:</p>

                            @php $latest = $book->notes->first(); @endphp
                            <div class="mb-3 border-bottom small">
                                {{--                                <span>{{ $latest->reader->name }}</span>--}}
                                <div class="ms-3">
                                    <p class="mb-1">- {{ $latest->note }}</p>
                                    <span class="small-sm">{{ date_format($latest->created_at, 'Y-m-d | H:i:s') }}</span>
                                </div>
                            </div>

                            @if($book->notes->count() > 1)
                                <p class="d-inline-flex gap-1">
                                    <a data-bs-toggle="collapse" href="#collapseNote" role="button" aria-expanded="false" aria-controls="collapseNote">
                                        Show more
                                    </a>
                                </p>
                                <div class="collapse" id="collapseNote">
                                    <div class="card card-body bg-transparent border-0">
                                        @foreach($book->notes as $note)
                                            @continue($loop->first)
                                            <div class="mb-3 border-bottom small">
                                                {{--                                            <span>{{ $note->reader->name }}</span>--}}
                                                <div class="ms-3">
                                                    <p class="mb-1">- {{ $note->note }}</p>
                                                    <span class="small-sm">{{ date_format($note->created_at, 'Y-m-d | H:i:s') }}</span>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                        </div>
                    @endif

                </div>
            </div>
        </div>
    </main>
@endsection



