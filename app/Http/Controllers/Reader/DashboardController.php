<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cookie;

class DashboardController extends Controller
{
    public function __construct()
    {
        auth('reader')->check();
    }

    public function index()
    {
        $reader = auth('reader')->user();

        $registeredBooks = Book::query()
            ->whereHas('registrations', function (Builder $q) use ($reader) {
                $q->where('reader_id', $reader['id']);
            })
            ->with(['registrations.user', 'reader'])
            ->get();

        $likedBooks = Book::query()
            ->whereIn('id', json_decode(Cookie::get('likedBooks'), true))
            ->get();

        $data = [
            'registeredBooks' => $registeredBooks,
            'likedBooks' => $likedBooks,
        ];

        return view('reader.dashboard.index')->with($data);
    }
}
