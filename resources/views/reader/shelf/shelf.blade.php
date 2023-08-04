<div class="d-block" style="max-width: 12rem; max-height: 25rem">
    <div class="border rounded p-2">
        <a href="{{ route('shelves.show', $shelf->id) }}">
            <img src="{{ $shelf->image() }}" alt="{{ $shelf->name }}" class="img-fluid">
        </a>
    </div>
    <div class="small">
        <div class="d-flex justify-content-around bg-success-subtle text-success-emphasis rounded mt-2">
            <div class="col-auto mb-1 fw-bolder">
                <a href="{{ route('shelves.books', ['id' => $shelf->id]) }}" class="text-success-emphasis">
                    Shelf {{ strtoupper($shelf->name) }}
                </a>
            </div>
            <div class="col-auto"><span class="fw-bolder">{{ $shelf->books_count }}</span> {{ $shelf->books_count > 1 ? 'books' : 'book' }}</div>
        </div>
    </div>
</div>
