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
use Illuminate\Support\Facades\DB;
use function Psy\sh;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $authCreds = json_decode(Cookie::get('auth'), true);
        $exists = DB::table('password_reset_tokens')->where('phone', $authCreds['phone'])
            ->where('token', $authCreds['token'])->exists();

        return $authCreds;
        return strval(Carbon::parse($authCreds['expires_at'])->diffAsCarbonInterval(Carbon::now()));

        //        $inCart = Cookie::has('cart') ? in_array(200, collect(json_decode(Cookie::get('cart'), true))->where('option', 'r')->pluck('id')->toArray()) : [];
//return $inCart;
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
