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
                @foreach($data as $part)
                    <div class="my-3 p-3 bg-body rounded shadow-sm">
                        <div class="d-flex justify-content-between border-bottom">
                            <div class="col-auto">
                                <h5 class="pb-2 mb-0">{{ $part['header'] }}</h5>
                            </div>
                            <div class="col-auto">
                                <div class="swiper-arrows">
                                    <span class="cursor-pointer custom-arrow bi-arrow-left-short custom-swiper-button-next"></span>
                                    <span class="cursor-pointer custom-arrow bi-arrow-right-short custom-swiper-button-prev"></span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between text-body-secondary pt-3">
                            <div class="swiper swiperLiked" id="swiper{{ $part['slug'] }}">
                                <div class="swiper-wrapper">
                                    @foreach($part['data'] as $product)
                                        <div class="swiper-slide mb-5 d-block">
                                            <div class="border rounded p-2">
                                                <a href="#">
                                                    <img src="{{ $product->image() }}" alt="{{ $product->name }}" class="img-fluid">
                                                </a>
                                            </div>
                                            <div class="small">
                                                <span class="mb-1" >{{ $product->name }}</span>
                                                <div class="text-center fw-semibold bg-success-subtle rounded">
                                                    <a href="" class="text-decoration-none text-success-emphasis">Rent: {{ number_format($product->price, '2', '.') }} <span class="font-monospace">TMT</span></a>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                </div>
                                <div class="swiper-pagination"></div>
                            </div>

                        </div>
                    </div>
                @endforeach
            @endif
        </main>
    @endsection
