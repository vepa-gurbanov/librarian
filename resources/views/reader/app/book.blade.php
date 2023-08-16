<div class="border rounded p-2">
    <a href="{{ route('books.show', $book->slug) }}">
        <img src="{{ $book->image() }}" alt="{{ $book->name }}" class="img-fluid">
    </a>
</div>
<div class="small">
    <div class="fw-bolder">
        @foreach($book->categories as $category)
            <a href="{{ route('books.index', ['c' => [[$category->id]]]) }}" class="tdn">{{ $category->name }}</a>
            @if(!$loop->last)
                ,
            @endif
        @endforeach
    </div>
    <div class="mb-1">
        {{ $book->name }}
    </div>
    <div class="d-block mt-auto w-100">
        @php
            use \Illuminate\Support\Facades\Cookie;
                $liked = in_array($book->id, Cookie::has('likedBooks') ? json_decode(Cookie::get('likedBooks'), true) : []) ? 'text-danger' : 'text-dark';
                $inCart = Cookie::has('cart') ? in_array($book->id, collect(json_decode(Cookie::get('cart'), true))->where('option', 'r')->pluck('id')->toArray()) : [];
        @endphp
        <a href="javascript:void(0);" id="{{ $book->id }}" content="like" class="text-decoration-none bg-success-subtle rounded-start ps-1">
            <span class="{{ $liked }}">
                <i class="bi-hand-thumbs-up-fill"></i>
            </span>
        </a>
        <span class="text-center fw-semibold bg-success-subtle px-1 mx-1">
            Rent: {!! $book->priceFormat('price') !!}
        </span>
        <a href="javascript:void(0);" id="{{ $book->id }}" option="r" remove="{{ $inCart }}" content="cart" class="text-decoration-none bg-success-subtle rounded-end px-1">
            <span class="text-{{ $inCart ? 'success' : 'dark' }}">
                <i class="bi-cart-{{ $inCart ? 'check' : 'plus' }}-fill"></i>
            </span>
        </a>
    </div>
</div>

