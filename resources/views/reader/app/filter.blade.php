<form action="{{ route('books.index') }}" method="GET" id="bookFilter">
    <div class="mb-3 gap-3 d-flex justify-content-between">
        <button type="submit" class="btn btn-sm w-100 btn-primary bi-filter">Filter</button>
        <a href="{{ route('books.index') }}" class="btn btn-sm w-100 btn-outline-danger bi-x">Clear</a>
    </div>
    <div class="mb-3">
        <input type="text" class="form-control form-control-sm" name="q" value="{{ $q }}" placeholder="[name, author, published year, ISBN]">
    </div>
    <div class="mb-3">
        <select class="form-select form-select-sm" name="ordering" id="ordering" size="1" onchange="$('form#bookFilter').submit();">
            <option value>@lang('lang.ordering'): @lang('lang.default')</option>
            @foreach(array_keys(config()->get('settings.ordering')) as $ordering)
                <option value="{{ $ordering }}" {{ $ordering == $f_order ? 'selected' : '' }}>
                    @lang('lang.' . $ordering)
                </option>
            @endforeach
        </select>
    </div>

    <!-- Start filter scroll -->
    <div class="scrollbar px-2" id="scrollbar">

        <!-- Start filter/price scroll -->
        <div class="bg-white border rounded p-2 mb-3">
            <div class="d-flex justify-content-between cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapsePrice" aria-expanded="false" aria-controls="collapsePrice">
                <span class="small"><b>Price</b></span>
                <span class="bi-caret-down-fill"></span>
            </div>
            <div class="collapse show" id="collapsePrice">
                <div class="d-flex justify-content-between mt-2">
                    <input type="text" class="form-control form-control-sm w-25 bg-light-subtle bordered" name="f_min_price" id="f_min_price" placeholder="{{ '0' }}" value="{{ $f_min_price }}">
                    -
                    <input type="text" class="form-control form-control-sm w-25 bg-light-subtle bordered" name="f_max_price" id="f_max_price" placeholder="{{ $maxPrice }}" value="{{ $f_max_price }}">
                    <span class="bi-search"></span>
                </div>
            </div>
        </div> <!-- End filter/price scroll -->

        <!-- Start filter/option scroll -->
        <div class="bg-white border rounded p-2 mb-3">
            <div class="d-flex justify-content-between cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapseOption" aria-expanded="false" aria-controls="collapseOption">
                <span class="small"><b>Options</b></span>
                <span class="bi-caret-down-fill"></span>
            </div>
            <div class="collapse show" id="collapseOption">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="eb" id="electron" value="1" {{ $eb ? 'checked' : '' }}>
                    <label class="form-check-label" for="electron">Electron: pdf, epub</label>
                </div>
                <div class="form-check form-switch small">
                    <input class="form-check-input" type="checkbox" role="switch" name="ab" id="audiobook" value="1" {{ $ab ? 'checked' : '' }}>
                    <label class="form-check-label" for="audiobook">Audiobook: mp3</label>
                </div>
            </div>
        </div> <!-- End filter/option scroll -->

        <!-- Start filter/Category scroll -->
        <div class="bg-white border rounded p-2 mb-3">
            <div class="d-flex justify-content-between cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
                <span class="small"><b>Categories</b></span>
                <span class="bi-caret-down-fill"></span>
            </div>
            <div class="collapse" id="collapseCategory">
                <div class="mt-2">
                    <input type="text" class="form-control form-control-sm bg-light-subtle bordered" id="search_category" placeholder="..." value="{{ old('search_category') }}">
                </div>
                <div class="mt-3 scrollbar" id="categoryScroll" content="category">
                    @foreach($searchCategories as $category)
                        <div class="form-check ms-2 small" id="filterContent">
                            <input class="form-check-input bordered" type="checkbox" name="c[{{ $category->id }}][]" value="{{ $category->id }}" id="checkCategory-{{ $category->id }}" {{ $f_categories->contains($category->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="checkCategory-{{ $category->id }}">
                                {{ $category->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div> <!-- End filter/Category scroll -->

        <!-- Start filter/Author scroll -->
        <div class="bg-white border rounded p-2 mb-3">
            <div class="d-flex justify-content-between cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapseAuthor" aria-expanded="false" aria-controls="collapseAuthor">
                <span class="small"><b>Authors</b></span>
                <span class="bi-caret-down-fill"></span>
            </div>
            <div class="collapse" id="collapseAuthor">
                <div class="mt-2">
                    <input type="text" class="form-control form-control-sm bg-light-subtle bordered" id="search_author" placeholder="..." value="{{ old('search_author') }}">
                </div>
                <div class="mt-3 scrollbar" id="authorScroll" content="author">
                    @foreach($searchAuthors as $author)
                        <div class="form-check ms-2 small" id="filterContent">
                            <input class="form-check-input" type="checkbox" name="au[{{ $author->id }}][]" value="{{ $author->id }}" id="checkAuthor-{{ $author->id }}" {{ $f_authors->contains($author->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="checkAuthor-{{ $author->id }}">
                                {{ $author->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div> <!-- End filter/Author scroll -->

        <!-- Start filter/Publisher scroll -->
        <div class="bg-white border rounded p-2 mb-3">
            <div class="d-flex justify-content-between cursor-pointer" data-bs-toggle="collapse" data-bs-target="#collapsePublisher" aria-expanded="false" aria-controls="collapsePublisher">
                <span class="small"><b>Publishers</b></span>
                <span class="bi-caret-down-fill"></span>
            </div>
            <div class="collapse" id="collapsePublisher">
                <div class="mt-2">
                    <input type="text" class="form-control form-control-sm bg-light-subtle bordered" id="search_publisher" placeholder="..." value="{{ old('search_publisher') }}">
                </div>
                <div class="mt-3 scrollbar" id="publisherScroll" content="publisher">
                    @foreach($searchPublishers as $publisher)
                        <div class="form-check ms-2 small" id="filterContent">
                            <input class="form-check-input bordered" type="checkbox" name="pub[{{ $publisher->id }}][]" value="{{ $publisher->id }}" id="checkPublisher-{{ $publisher->id }}" {{ $f_publishers->contains($publisher->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="checkPublisher-{{ $publisher->id }}">
                                {{ $publisher->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
        </div> <!-- End filter/Publisher scroll -->

    </div> <!-- End filter scroll -->
</form>
