<div class="border rounded p-2">
    <a href="#">
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
    <div class="text-center fw-semibold bg-success-subtle rounded d-block mt-auto;">
        <a href="" class="text-decoration-none text-success-emphasis">Rent: {{ number_format($book->price, '2', '.') }} <span class="font-monospace">TMT</span></a>
    </div>
</div>
