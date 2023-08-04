@extends('reader.layouts.app')
@section('title')
    Shelf {{ strtoupper($shelf->name) }}
@endsection
@section('content')
    <main class="container-xl mt-3">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('shelves.index') }}">Shelves</a></li>
                <li class="breadcrumb-item active" aria-current="page">Shelf <b>{{ strtoupper($shelf->name) }}</b></li>
            </ol>
        </nav>

        <div class="row row-cols-2">
            <div class="col">
                <img src="{{ $shelf->image() }}" class="img-fluid">
            </div>
            <div class="col">
                <div class="mb-3">
                    <span class="fst-italic">Shelf ID: </span> <span class="fw-bolder">{{ $shelf->id }}</span>
                </div>
                <div class="mb-3">
                    <span class="fst-italic">Shelf Name: </span> <span class="fw-bolder">{{ $shelf->name }}</span>
                </div>
                <div class="mb-3">
                    <span class="fst-italic">Total books: </span> <span class="fw-bolder">{{ $shelf->books_count }}</span>
                </div>
                <div class="mb-3">
                    <span class="fst-italic">Ordering: </span> <span class="fw-bolder">{{ $shelf->sort_order }}</span>
                </div>
                @if(isset($shelf->reader))
                    <div class="mb-3">
                        <span class="fst-italic">Owner: </span> <span class="fw-bolder">{{ $shelf->reader->name }}</span>
                    </div>
                    @if(auth('reader')->check() && auth('reader')->id() === $shelf->reader->id)
                        <div class="mb-3">
                            <a href="{{ route('shelves.edit', $shelf->id) }}" class="btn btn-sm btn-outline-success">
                                <i class="bi-pencil-square"></i> Edit
                            </a>
                        </div>
                        <div class="mb-3">
                            <button type="button" data-bs-target="#deleteShelf{{ $shelf->id }}" data-bs-toggle="modal" class="btn btn-sm btn-outline-danger">
                                <i class="bi-trash"></i> Delete
                            </button>

                            <div class="modal fade" id="deleteShelf{{ $shelf->id }}" tabindex="-1" aria-labelledby="deleteShelf{{ $shelf->id }}Label" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <div class="modal-title fs-6 fw-semibold" id="deleteShelf{{ $shelf->id }}Label">
                                                Remove shelf <b>{{ $shelf->name }}</b>?
                                            </div>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{ route('shelves.destroy', $shelf->id) }}" method="post">
                                                @method('deleteShelf')
                                                @csrf
                                                <button type="button" class="btn btn-light btn-sm" data-bs-dismiss="modal">No</button>
                                                <button type="submit" class="btn btn-secondary btn-sm"><i class="bi-trash"></i>Yes</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </main>
@endsection
