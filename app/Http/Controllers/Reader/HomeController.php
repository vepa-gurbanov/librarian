<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Option;
use App\Models\Shelf;
use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $id = 10;
        $aa = [
            '1' => [
                'id' => 1,
                'title' => 'dewfwef dwed fewfewfdwe',
                'variants' => [
                    'r' => 'fewfwe',
                    'a' => null,
                    'e' => null,
                ]
            ],
            $id => [
                'id' => 2,
                'title' => 'rrr33 dwed fewfewfdwe',
                'variants' => [
                    'r' => 'ddd',
                    'a' => null,
                    'e' => null,
                ]
            ],
        ];

        Cookie::queue('sss', json_encode($aa), 7*24*60);


        return json_decode(Cookie::get('sss'), true);


        return collect(json_decode(Cookie::get('cart'), true));

        $book = Book::query()->where('id', 200)->with('options')->first(['id', 'full_name', 'price', 'image']);
//        return $book->options->where('type', 'audiobook')->first()->price;
//        return $book;
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

        $cart = collect(json_decode(Cookie::get('cart'), true));

//return asset('img/loading.gif');
//return collect(json_decode(Cookie::get('cart'), true))->where('option', 'r')->pluck('id');
//        return $cart->where('id', 180)->where('option', 'r')->pluck('id');

//        return $cart->groupBy('id');


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
