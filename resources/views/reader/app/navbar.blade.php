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

        <button class="btn btn-sm btn-outline-primary" data-bs-target="#loginModal" data-bs-toggle="modal">Join Us</button>

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



<div class="modal" id="registerModal" aria-hidden="true" aria-labelledby="registerModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h1 class="modal-title fs-5" id="registerModalLabel">
                    <button class="btn btn-sm btn-outline-primary" name="loginModal" data-bs-target="#loginModal" data-bs-toggle="modal">Login</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Current page">Register</button>
                    <button class="btn btn-sm btn-outline-primary" name="verifyModal" data-bs-target="#verifyModal" data-bs-toggle="modal">I have Code</button>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <div class="text-center">
                    <h4>Sign up</h4>
                    <p>Sign up to continue</p>
                </div>
                <form action="{{ route('register') }}" method="POST" id="registerForm" class="row g-3 mx-5 needs-validation" novalidate>
                    @csrf
                    @method('POST')
                    @honeypot
                    <div class="mb-3">
                        <label for="register-name" class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="name" id="register-name" placeholder="ex: St Jones" autocomplete="off" autofocus required>
                        <div id="register-name-feedback"></div>
                    </div>
                    <div class="mb-3">
                        <label for="register-phone" class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" id="registerPhone">+993</span>
                            <input type="text" class="form-control form-control-sm" name="phone" id="register-phone" aria-describedby="registerPhone" placeholder="60000000" autocomplete="off" required>
                        </div>
                        <div class="mt-1" name="feedback"></div>
                    </div>
                    <div class="mb-3">
                        <button type="button" name="register" class="btn btn-sm btn-primary w-100">Get Verification code</button>
                        {{--                        <button type="button" name="register" class="btn btn-sm btn-primary w-100" data-bs-target="#verifyModal" data-bs-toggle="modal">Get Verification code</button>--}}
                    </div>
                    <p class="resend text-center text-muted mb-0">
                        Already registered? <a href="javascript:void(0);" onclick="$('[name=loginModal]').click()">Log In</a>
                    </p>
                </form>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="loginModal" aria-hidden="true" aria-labelledby="loginModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h1 class="modal-title fs-5" id="loginModalLabel">
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Current page">Login</button>
                    <button class="btn btn-sm btn-outline-primary" name="registerModal" data-bs-target="#registerModal" data-bs-toggle="modal">Register</button>
                    <button class="btn btn-sm btn-outline-primary" name="verifyModal" data-bs-target="#verifyModal" data-bs-toggle="modal">I have Code</button>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5">
                <div class="text-center">
                    <h4>Sign in</h4>
                    <p>Sign in to continue</p>
                </div>
                <form action="{{ route('login') }}" method="POST" id="loginForm" class="row g-3 mx-5 needs-validation" novalidate>
                    @csrf
                    @method('POST')
                    @honeypot
                    <div class="mb-3">
                        <label for="login-phone" class="form-label fw-semibold">Phone <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text" id="loginPhone">+993</span>
                            <input type="text" class="form-control form-control-sm" name="phone" id="login-phone" aria-describedby="loginPhone" placeholder="60000000" autocomplete="off" autofocus required>
                        </div>
                        <div class="mt-1" name="feedback"></div>
                    </div>
                    <div class="mb-3">
                        <button type="button" name="login" class="btn btn-sm btn-primary w-100">Get Verification code</button>
                        {{--                        <button type="button" name="login" class="btn btn-sm btn-primary w-100" data-bs-target="#verifyModal" data-bs-toggle="modal">Get Verification code</button>--}}
                    </div>
                    <p class="resend text-center text-muted mb-0">
                        Don't you have account? <a href="javascript:void(0);" onclick="$('[name=registerModal]').click()">Sign up</a>
                    </p>
                </form>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="verifyModal" aria-hidden="true" aria-labelledby="verifyModalLabel" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header border-bottom-0">
                <h1 class="modal-title fs-5" id="verifyModalLabel">
                    <button class="btn btn-sm btn-outline-primary" name="loginModal" data-bs-target="#loginModal" data-bs-toggle="modal">Login</button>
                    <button class="btn btn-sm btn-outline-primary" name="registerModal" data-bs-target="#registerModal" data-bs-toggle="modal">Register</button>
                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Current page">I have Code</button>
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-5 text-center">
                <form action="{{ route('verify') }}" method="POST" id="verify">
                    @csrf
                    @method('POST')
                    @honeypot
                    <h4>Verify</h4>
                    <p id="verifyHelpText"></p>

                    <div class="text-start mb-3">
                        <label for="verify" class="form-label fw-semibold">Verification Code <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm" name="code" id="verify" placeholder="Enter code: 5 digits" autocomplete="off" autofocus required>
                        <div class="mt-1" name="feedback"></div>
                    </div>
                    <div class="mb-3">
                        <button type="button" name="verify" class="btn btn-sm btn-primary w-100">Get Verification code</button>
                    </div>
                    <p class="resend text-muted mb-0">
                        Didn't receive code? <a href="javascript:void(0);" id="resend">Request again</a>
                    </p>
                </form>
            </div>
            <div class="modal-footer border-top-0">
                <button type="button" class="btn btn-sm btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
