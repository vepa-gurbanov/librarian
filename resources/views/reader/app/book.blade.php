<div class="border rounded p-2">
    <a href="{{ route('books.show', $book->slug) }}">
        <img src="{{ $book->image() }}" alt="{{ $book->name }}" class="img-fluid">
    </a>
</div>
<div class="small">
    <div class="fw-bolder">
        @foreach($book->categories as $category)
            <a href="{{ route('books.index', ['c' => [[$category->id]]]) }}" class="tdn">{{ $category->name }}</a>
            @if(!$loop->last), @endif
        @endforeach
    </div>
    <div class="mb-1">
        {{ $book->name }}
    </div>
    <div class="d-block mt-auto">
        @php
            $liked = in_array($book->id, json_decode(\Illuminate\Support\Facades\Cookie::get('likedBooks'), true)) ? 'text-danger' : 'text-dark';
        @endphp
        <span class="text-center fw-semibold bg-success-subtle rounded-start me-1 ps-1">
        <a href="javascript:void(0);" class="bi-hand-thumbs-up-fill {{ $liked }}" content="like"  id="{{ $book->id }}"></a>
        </span>
        <span class="text-center fw-semibold bg-success-subtle rounded-end px-1">
        <a href="#" class="text-decoration-none text-success-emphasis">Rent: {!! $book->priceFormat('price') !!}</a>
        </span>
    </div>
</div>
