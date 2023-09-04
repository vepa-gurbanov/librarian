<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Validation\Validator;

class CartController extends Controller
{
    public function getCookie($name = 'cart') {
        return Cookie::has($name) ? json_decode(Cookie::get($name), true) : [];
    }

    public function setCookie(Request $request) {
        $validation = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'id' => ['required', 'integer', 'exists:readers,id'],
            'option' => ['required', 'sometimes', 'in:r,a,e,b'],
            'total_days' => ['required', 'sometimes', 'integer', 'min:0'],
            'receive_date_input' => ['required', 'sometimes', 'date'],
            'return_date_input' => ['required', 'sometimes', 'date', 'after:receive_date_input'],
            'remove' => ['required', 'sometimes', 'boolean'],
        ]);

        $cookie = $this->getCookie();

        if (! $request->has('receive_date_input')) {
            $receive_date = Carbon::today()->format('Y-m-d');
        } else {
            $receive_date = Carbon::parse($request->get('receive_date_input'))->format('Y-m-d');
        }
        if (! $request->has('return_date_input')) {
            $return_date = Carbon::tomorrow()->format('Y-m-d');
        } else {
            $return_date = Carbon::parse($request->get('return_date_input'))->format('Y-m-d');
        }

        $book = Book::query()->where('id', $request->get('id'))->with('options')->first(['id', 'full_name', 'price', 'image']);

        if (!$cookie[$request->get('id')]) {

        } else {
            $cookie = $cookie[$request->get('id')];
            if ($request->has('remove') || $request->has('total_days') < 1) {unset($cookie['variants'][$request->get('option')]);};

        }


        if ($option === 'r') {
            $r = [
                'price' => $book->price(),
                'quantity' => $qty,
                'total_price' => $qty * $book->price(),
                'total_days' => $returnDate->diffInDays($receiveDate),
                'receive_date' => $receiveDate->format('Y-m-d'),
                'return_date' => $returnDate->format('Y-m-d'),
            ];
        } elseif ($option === 'a') {
            $a = [
                'price' => $book->options->where('type', 'audiobook')->first()->price,
            ];
        } elseif ($option === 'e') {
            $e = [
                'price' => $book->options->where('type', 'electron')->first()->price,
            ];
        }

        if (!$cookie[$id]) {
            $batch = [
                $id => [
                    'id' => $id,
                    'title' => $book->full_name,
                    'variants' => [
                        'r' => $option === 'r' ? $r : null,
                        'a' => $option === 'a' ? $a : null,
                        'e' => $option === 'e' ? $e : null,
                    ]
                ]
            ];
        }


    }


    public function checkout() {
    }
}
