<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $top = Book::orderBy('liked', 'desc')
            ->take(10)
            ->get(['name', 'slug', 'price', 'page', 'liked'])->debug();

        $data = [
            [
                'data' => $top,
                'header' => 'Readers liked',
                'slug' => 'Like',
            ],
        ];

        return view('reader.home.index')
            ->with(['data' => $data]);
    }
}
