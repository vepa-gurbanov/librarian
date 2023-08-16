@extends('reader.layouts.app')
@section('title')
    @lang('lang.dashboard')
@endsection
@section('content')
    <main class="container">

        <div class="card shadow my-3">
            <div class="card-header d-flex justify-content-between py-3">
                <div class="col-auto">
                    <a class="h6 m-0 font-weight-bold btn btn-sm btn-primary" data-bs-toggle="collapse"
                       href="#collapseInCartBooks" role="button" aria-expanded="true"
                       aria-controls="collapseInCartBooks">Ready to checkout <span id="caret" class="bi-caret-down-fill"></span></a>
                    <span class="text-end fw-semibold">({{ count($inCartBooks) }})</span>
                </div>
                <div class="col-auto">
                    <a href="#" class="btn btn-sm btn-primary">Checkout</a>
                </div>
            </div>
            <div class=" collapse show" id="collapseInCartBooks">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" id="inCartBooks" searchable="">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">@lang('lang.image')</th>
                                <th scope="col">@lang('lang.owner')</th>
                                <th scope="col">@lang('lang.description')</th>
                                <th scope="col">@lang('lang.tools')</th>
                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th scope="col" width="5%">#</th>
                                <th scope="col" width="10%">@lang('lang.image')</th>
                                <th scope="col" width="15%">@lang('lang.owner')</th>
                                <th scope="col"width="60%">@lang('lang.description')</th>
                                <th scope="col" width="10%">@lang('lang.tools')</th>
                            </tr>
                            </tfoot>
                            <tbody>
                            @foreach($inCartBooks as $book)
                                <tr>
                                    <th scope="row">{{ $loop->iteration }}</th>
                                    <td><img src="{{ $book[0]->image() }}" class="img-fluid border rounded p-2" width="80"></td>
                                    <td class="small">
                                        <div>
                                            <span class="fw-semibold">@lang('lang.owner'):</span>
                                            {{ $book[0]->reader->name ?? 'Admin' }}
                                        </div>
                                    </td>
                                    <td class="small">
                                        <div><span class="fw-semibold">@lang('lang.name'):</span> {{ $book[0]->full_name }}</div>
                                        <div><span class="fw-semibold">@lang('lang.book-code'):</span> {{ $book[0]->book_code }}</div>
                                        <div><span class="fw-semibold">@lang('lang.pages'):</span> {{ $book[0]->page }}</div>
                                        <div><span class="fw-semibold">@lang('lang.price'):</span> {{ number_format($book[1]['price'], 2) }} <span class="small-sm font-monospace">TMT</span></div>
                                        <div><span class="fw-semibold">@lang('lang.option'):</span> {{ trans('lang.' . config('settings.purchase')[$book[1]['option']]) }}</div>
                                    </td>
                                    <td>
                                        <a href="javascript:void(0);" class="bi-trash-fill text-danger" content="dislike" option="{{ $book[1]['option'] }}"  id="{{ $book[0]->id }}"></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <button type="button" class="btn btn-bd-primary w-100 text-center p-3 my-3 text-white rounded shadow-sm"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">Checkout
                    </button>
                </div>
            </div>
        </div>




        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header border-bottom-0">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Checkout</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @include('reader.app.checkout')
                    </div>
                    <div class="modal-footer border-top-0">
                        <button type="button" class="btn btn-sm btn-light">Save changes</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>





        <div class="card shadow my-3">
            <div class="card-header py-3">
                <a class="h6 m-0 font-weight-bold btn btn-sm btn-primary" data-bs-toggle="collapse"
                   href="#collapseRegisteredBooks" role="button" aria-expanded="false"
                   aria-controls="collapseRegisteredBooks">Registered books <span id="caret" class="bi-caret-down-fill"></span></a>
                <span class="text-end fw-semibold">({{ $registeredBooks->count() }})</span>
            </div>
            <div class="collapse" id="collapseRegisteredBooks">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered dataTable" id="registeredBooks" searchable="true">
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
                            @foreach($registeredBooks as $book)
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

        <div class="card shadow my-3">
            <div class="card-header py-3">
                <a class="h6 m-0 font-weight-bold btn btn-sm btn-primary" data-bs-toggle="collapse"
                   href="#collapseLikedBooks" role="button" aria-expanded="false"
                   aria-controls="collapseLikedBooks">Liked books <span id="caret" class="bi-caret-down-fill"></span></a>
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
