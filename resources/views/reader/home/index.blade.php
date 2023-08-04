@extends('reader.layouts.app')
@section('title')
    Home
@endsection
@section('content')
    <form action="{{ route('home') }}" method="GET" id="bookFilter">
    </form>

    @if(!request()->has('q'))
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
    @endif
    <main class="container">
        {{--        <div class="d-flex align-items-center p-3 my-3 text-white bg-purple rounded shadow-sm">--}}
        {{--            <img class="me-3" src="{{ asset('img/logo.png') }}" alt="" width="48" height="38">--}}
        {{--            <div class="lh-1">--}}
        {{--                <h1 class="h6 mb-0 text-white lh-1">Bootstrap</h1>--}}
        {{--                <small>Since 2011</small>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        @if(request()->has('q'))
            <div class="my-3 p-3 bg-body rounded shadow-sm">
                <div class="d-flex justify-content-between border-bottom">
                    <div class="col-auto">
                        <h5 class="pb-2 mb-0">Searched</h5>
                    </div>
                    <div class="col-auto">
                        <small>{{ request()->q }}</small>
                    </div>
                </div>
                <div class="row row-cols-3 row-cols-md-4 row-cols-xl-5 g-4 mb-4 pt-3">
                    @foreach($data[0]['books'] as $book)
                        <div class="col">
                            @include('reader.app.book')
                        </div>
                    @endforeach
                </div>
            </div>
        @else
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
        @endif
    </main>
@endsection
