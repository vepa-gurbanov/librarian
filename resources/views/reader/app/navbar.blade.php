<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
    <div class="container-fluid">
        <div class="d-flex bg-white rounded">
            <a href="{{ route('home') }}" class="text-decoration-none">
                <img class="mx-2 p-1" src="{{ asset('img/logo.png') }}" alt="" width="40" height="40"></a>
            <div class="h6 mt-3 mb-0 me-2 fw-bolder font-monospace">{{ config('app.name') }}</div>
        </div>
        <div class="d-flex">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                @auth('reader')
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                    </li>
                @endauth
                <li class="nav-item dropdown">
                    <a class="nav-link {{ request()->routeIs('books.index') ? 'active' : '' }} dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Books</a>
                    <ul class="dropdown-menu" style="max-width: 1080px; max-height: 480px">
                        <li>
                            <a class="dropdown-item" href="{{ route('books.index') }}">
                                See all Books
                            </a>
                        </li>
                        @foreach($categories as $category)
                            <li>
                                <a class="dropdown-item" href="{{ route('books.index', ['c' => [[$category->id]]]) }}">
                                    {{ $category->name }}
                                    <span class="badge text-bg-light rounded-pill align-text-bottom">{{ $category->books_count }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </li>

                <li class="nav-item dropdown-center">
                    <a class="nav-link {{ request()->routeIs('shelves.*') ? 'active' : '' }} dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Shelves</a>
                    <div class="dropdown-menu" style="width: 610px; height: 210px">
                        <div class="row row-cols-3 row-cols-md-4 row-cols-xl-5">
                            <div class="col-auto">
                                <a class="dropdown-item" href="{{ route('shelves.index') }}">
                                    Shelves
                                </a>
                            </div>
                            @foreach($shelves as $shelf)
                                <div class="col-auto">
                                    <a class="dropdown-item" href="{{ route('shelves.books', ['id' => $shelf->id]) }}">
                                        Shelf <span class="fw-bolder">{{ strtoupper($shelf->name) }}</span>
                                        <span class="badge text-bg-light rounded-pill align-text-bottom">{{ $shelf->books_count }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </li>
            </ul>
        </div>

        <!-- Language -->
        <div class="dropdown-center">
            <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <small>
                    {{ array_key_exists($languages['locale'], $languages['available']) ? $languages['available'][$languages['locale']] : strtoupper($languages['locale']) }}
                </small>
                - <img src="{{ asset('img/flags/' . $languages['locale'] . '.png') }}" alt="" class="img-fluid" width="16" height="16">
            </button>
            <ul class="dropdown-menu">
                @foreach($languages['available'] as $key => $val)
                    @continue($key == $languages['locale'])
                    <li style="font-size: .875em;">
                        <a class="custom-nav-link dropdown-item" href="{{ route('language', $key) }}">
                            <small>
                                {{ $val }}
                            </small>
                            - <img src="{{ asset('img/flags/' . $key . '.png') }}" alt="" class="img-fluid" width="16" height="16">
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- //. end Language -->

        <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
            @auth('reader')
                <form action="{{ route('logout') }}" method="POST" id="ReaderLogoutForm">
                    @csrf
                    @honeypot
                </form>
                <li class="nav-item">
                    <a class="nav-link bi-arrow-left-square-fill" href="javascript:void(0);" onclick="$('form#ReaderLogoutForm').submit();"> Logout</a>
                </li>
            @else
                <li class="nav-item">
                    <span class="d-inline-flex">
                    <a class="nav-link" href="{{ route('login') }}">Login</a> <span class="text-white nav-link">/</span> <a class="nav-link" href="{{ route('register') }}">Register</a>

                </span>
                </li>
            @endif
        </ul>

        <form class="d-flex" role="search" method="GET" action="{{ route('home') }}">
            <div class="input-group">
                <input type="text" class="form-control rounded-pill rounded-end-0" name="instant_search" placeholder="Search.." />
                <button type="submit" class="input-group-text bg-primary rounded-pill rounded-start-0"><i class="bi-search"></i></button>
            </div>
        </form>
    </div>
</nav>

<div class="nav-scroller bg-body shadow-sm">
    <nav class="nav d-flex justify-content-between" aria-label="Secondary navigation">
        @foreach($authors as $author)
            <a class="nav-link col" href="{{ route('books.index', ['au' => [[$author->id]]]) }}">
                {{ $author->name }}
                <span class="badge text-bg-light rounded-pill align-text-bottom">{{ $author->books_count }}</span>
            </a>
        @endforeach
    </nav>
</div>
