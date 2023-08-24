<div class="swiper-slide mb-5 d-block" style="max-width: 12rem; max-height: 25rem">
    <div class="border rounded p-2">
        <a href="{{ $key === 'shelf' ? route('shelves.show', $value->id) : route('books.show', $value->slug) }}">
            <img src="{{ $value->image() }}" alt="{{ $value->name }}" class="img-fluid">
        </a>
    </div>
    <div class="small">

        @php
            use \Illuminate\Support\Facades\Cookie;
                $liked = in_array($value->id, Cookie::has('likedBooks') ? json_decode(Cookie::get('likedBooks'), true) : []) ? 'text-danger' : 'text-dark';
                $inCart = in_array($value->id, Cookie::has('cart') ? collect(json_decode(Cookie::get('cart'), true))->where('option', 'r')->pluck('id')->toArray()  : []);
        @endphp

        @if($key === 'shelf')
            <div class="d-flex justify-content-around bg-success-subtle text-success-emphasis rounded mt-2">
                <div class="col-auto mb-1 fw-bolder">
                    <a href="{{ route('shelves.index', ['sh' => [$value->id]]) }}" class="text-success-emphasis">
                        Shelf {{ strtoupper($value->name) }}
                    </a>
                </div>
                <div class="col-auto"><span class="fw-bolder">{{ $value->books_count }}</span> {{ $value->books_count > 1 ? 'books' : 'book' }}</div>
            </div>
        @else
            <span class="mb-1 fw-bolder small-sm" >{{ $value->name }}</span>

            <div class="d-block mt-auto w-100">
                <a href="javascript:void(0);" onclick="$('#like{{ $value->id }}').submit()"
                   class="text-decoration-none bg-success-subtle {{ $liked }} rounded-start ps-1 bi-hand-thumbs-up-fill"></a>

                <span class="text-center fw-semibold bg-success-subtle px-1 mx-1">
                    Rent: {!! $value->priceFormat('price') !!}
                </span>

                <a href="javascript:void(0);" onclick="$('#addToCart{{ $value->id }}').submit()"
                   class="text-decoration-none bg-success-subtle text-{{ $inCart ? 'success' : 'dark' }} rounded-end px-1 bi-cart-{{ $inCart ? 'check' : 'plus' }}-fill"></a>
            </div>
            <form method="GET" action="{{ route('book.like', $value->id) }}" id="like{{ $value->id }}">
                <input type="hidden" name="id" value="{{ $value->id }}">
            </form>
            <form method="GET" action="{{ route('cart') }}" id="addToCart{{ $value->id }}">
                <input type="hidden" name="id" value="{{ $value->id }}">
                <input type="hidden" name="option" value="r">
                <input type="hidden" name="remove" value="{{ $inCart }}">
            </form>
        @endif
    </div>
</div>
