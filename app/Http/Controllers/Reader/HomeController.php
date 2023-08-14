<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Shelf;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use function Psy\sh;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $top = Book::query()
            ->orderBy('liked', 'desc')
            ->take(10)
            ->with('categories:id,slug,name')
            ->get(['id', 'name', 'slug', 'price', 'page', 'liked', 'image']);


        $shelves = Shelf::query()
            ->withCount('books')
            ->orderByDesc('books_count')
            ->orderBy('name')
            ->orderBy('sort_order')
            ->take(10)
            ->get(['id', 'name', 'image', 'books_count']);

        $data = [
            'swiperContent' => [
                'top' => [
                    'data' => $top,
                    'header' => 'Readers liked',
                    'slug' => 'Like',
                ],
                'shelf' => [
                    'data' => $shelves,
                    'header' => 'Shelves',
                    'slug' => 'Shelf',
                ],
            ],
        ];

        return view('reader.home.index')->with($data);
    }


    public function language($key): \Illuminate\Http\RedirectResponse
    {
        if (array_key_exists($key, config('settings.languages'))) {
            session()->put('locale', $key);
        } else {
            session()->put('locale', 'en');
        }

        return redirect()->back()->with('success', 'Localization successfully changed!');
    }
}
