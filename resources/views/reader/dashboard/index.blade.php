@extends('reader.layouts.app')
@section('title')
    @lang('lang.dashboard')
@endsection
@section('content')
    <main class="container">
        <div class="card shadow my-3">
            <div class="card-header py-3">
                <a class="h6 m-0 font-weight-bold text-primary" data-bs-toggle="collapse" href="#collapseLikedBooks" role="button" aria-expanded="false" aria-controls="collapseLikedBooks">Liked books</a>
                <span class="text-end fw-semibold">({{ $likedBooks->count() }})</span>
            </div>
            <div class="collapse" id="collapseLikedBooks">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" id="likedBooks" searchable="true">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('lang.image')</th>
                                <th scope="col">@lang('lang.name')</th>
                                <th scope="col">@lang('lang.price')</th>
                                <th scope="col">@lang('lang.dislike')</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('lang.image')</th>
                                <th scope="col">@lang('lang.name')</th>
                                <th scope="col">@lang('lang.price')</th>
                                <th scope="col">@lang('lang.dislike')</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($likedBooks as $book)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td><img src="{{ $book->image() }}" class="img-fluid border rounded p-2" width="48"></td>
                                    <td>{{ $book->full_name }}</td>
                                    <td>{!! $book->priceFormat('price') !!}</td>
                                    <td>
                                        <a href="javascript:void(0);" class="bi-trash-fill text-danger" content="like"  id="{{ $book->id }}"></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
                        <img class="me-3" src="{{ asset('img/logo.png') }}" alt="" width="48" height="38">
                        <div class="lh-1">
                            <h1 class="h6 mb-0 text-white lh-1">Bootstrap</h1>
                            <small>Since 2011</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
@endsection
