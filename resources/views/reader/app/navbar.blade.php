<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark" aria-label="Main navigation">
    <div class="container-fluid">
        <div>
            <img class="mx-2 p-1 bg-white rounded" src="{{ asset('img/logo.png') }}" alt="" width="40" height="40">
{{--            <h1 class="h6 mb-0 text-white">{{ config('app.name') }}</h1>--}}
        </div>

        <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">Books</a>
                    <ul class="dropdown-menu" style="max-width: 1080px; max-height: 480px">
                        @foreach($categories as $category)
                        <li><a class="dropdown-item" href="#">Action</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
            <form class="d-flex" role="search">
                <div class="input-group">
                    <input type="text" class="form-control rounded-5 rounded-end-0" placeholder="Search.." aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <button type="button" class="input-group-text bg-primary rounded-5 rounded-start-0" id="basic-addon2"><i class="bi-search"></i></button>
                </div>
            </form>
        </div>
    </div>
</nav>

<div class="nav-scroller bg-body shadow-sm">
    <nav class="nav" aria-label="Secondary navigation">
        <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
        <a class="nav-link" href="#">
            Friends
            <span class="badge text-bg-light rounded-pill align-text-bottom">27</span>
        </a>
        <a class="nav-link" href="#">Explore</a>
        <a class="nav-link" href="#">Suggestions</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
        <a class="nav-link" href="#">Link</a>
    </nav>
</div>
