@extends('reader.layouts.app')
@section('title')
    Home
@endsection
@section('content')
    <div class="btn-group" role="group">
        <button type="button" class="btn btn-sm btn-light rounded-pill rounded-end-0"
                data-bs-toggle="modal" data-bs-target="#registerModal" style="font-family: 'Courier New'">Sign up</button>
        <button type="button" class="btn btn-sm btn-primary rounded-pill rounded-start-0"
                data-bs-toggle="modal" data-bs-target="#exampleModal" style="font-family: 'Courier New'">Sign in</button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content border-0 shadow">
                <div class="modal-header bg-purple">
                    <h1 class="modal-title fs-5" id="registerModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>




    <div class="swiper swiperSlider m-3 rounded">
        <div class="swiper-wrapper">
            @foreach([1,2,3,4,5,6,7] as $i)
                <div class="swiper-slide">
                    <img src="{{ asset('img/slider-' . $i . '.jpg') }}">
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>

    <main class="container">
        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">
            <img class="me-3" src="{{ asset('img/logo.png') }}" alt="" width="48" height="38">
            <div class="lh-1">
                <h1 class="h6 mb-0 text-white lh-1">Bootstrap</h1>
                <small>Since 2011</small>
            </div>
        </div>

        @foreach($swiperContent as $key => $content)
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <div class="swiper swiperContent" id="swiper{{ $content['slug'] }}">
                    <div class="d-flex justify-content-between border-bottom mb-3">
                        <div class="col-auto">
                            <h5 class="pb-2 mb-0">{{ $content['header'] }}</h5>
                        </div>
                        <div class="col-auto">
                            <div class="swiper-arrows">
                                <span class="cursor-pointer custom-arrow bi-arrow-left-short custom-swiper-button-next"></span>
                                <span class="cursor-pointer custom-arrow bi-arrow-right-short custom-swiper-button-prev"></span>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-wrapper">
                        @foreach($content['data'] as $value)
                            @include('reader.app.book-swiper')
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        @endforeach
    </main>
@endsection
