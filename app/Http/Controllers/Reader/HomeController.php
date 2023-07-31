<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $request->validate(['q' => ['nullable', 'string']]);
        $top = Book::orderBy('liked', 'desc')
            ->take(10)
            ->get(['name', 'slug', 'price', 'page', 'liked']);

            $q = $request->q;
            $books = Book::where('name', 'like', '%' . $q . '%')
                ->orWhere('full_name', 'like', '%' . $q . '%')
                ->orWhere('slug', 'like', '%' . $q . '%')
                ->orWhere('barcode', 'like', '%' . $q . '%')
                ->orWhere('book_code', 'like', '%' . $q . '%')
                ->whereHas('authors', function ($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                })
                ->whereHas('categories', function ($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                })
                ->whereHas('publishers', function ($query) use ($q) {
                    $query->where('name', 'like', '%' . $q . '%');
                })
                ->orderBy('id')
                ->with('categories:id,slug,name')
                ->paginate(24, ['id', 'name', 'slug', 'price', 'page', 'liked'])
                ->withQueryString();

        $data = [
            [
                'books' => $books,
                'data' => $top,
                'header' => 'Readers liked',
                'slug' => 'Like',
            ],
        ];

        return view('reader.home.index')
            ->with(['data' => $data]);
    }
}
