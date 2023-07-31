<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
    <div class="container-fluid">
        <div class="d-flex bg-white rounded">
            <a href="{{ route('home') }}" class="tdn">
                <img class="mx-2 p-1" src="{{ asset('img/logo.png') }}" alt="" width="40" height="40"></a>
            <div class="h6 mt-3 mb-0 me-2 fw-bolder font-monospace">{{ config('app.name') }}</div>
        </div>
        <div class="d-flex">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    @auth('reader')
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">My account</a>
                        <form action="{{ route('logout') }}" method="POST" id="ReaderLogoutForm">
                            @csrf
                            @honeypot
                        </form>
                        <ul class="dropdown-menu" style="max-width: 1080px; max-height: 480px">
                            <li><a class="dropdown-item" href="#">Dashboard</a></li>
                            <li><a class="dropdown-item bi-arrow-left-short" href="javascript:void(0);" onclick="$('form#ReaderLogoutForm').submit();">Logout</a></li>
                        </ul>
                    @else
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Create Account</a>
                        <ul class="dropdown-menu" style="max-width: 1080px; max-height: 480px">
                            <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}">Register</a></li>
                        </ul>
                    @endif
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Books</a>
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
            </ul>
        </div>
        <form class="d-flex" role="search">
            <div class="input-group">
                <input type="text" class="form-control rounded-pill rounded-end-0" placeholder="Search.." id="searchbar" aria-describedby="searchbar" value="{{ request()->has('q') ? request('q') : '' }}" />
                <button type="button" class="input-group-text bg-primary rounded-pill rounded-start-0" id="searchbar"><i class="bi-search"></i></button>
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
