<div class="swiper-slide mb-5 d-block" style="max-width: 12rem; max-height: 25rem">
    <div class="border rounded p-2">
        <a href="{{ $key === 'shelf' ? route('shelves.show', $value->id) : route('books.show', $value->slug) }}">
            <img src="{{ $value->image() }}" alt="{{ $value->name }}" class="img-fluid">
        </a>
    </div>
    <div class="small">

        @if($key === 'shelf')
            <div class="d-flex justify-content-around bg-success-subtle text-success-emphasis border rounded mt-2">
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
                <span class="text-center fw-semibold bg-success-subtle text-success-emphasis border rounded px-1 mx-1">
                    Rent: {!! $value->priceFormat('price') !!}
                </span>
            </div>
        @endif

    </div>
</div>
