<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;

class AlgoliaSearchController extends Controller
{
    public function search($q = '') {
        return Book::search($q)->get();
    }
}
