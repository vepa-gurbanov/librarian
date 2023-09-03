<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Option;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class DashboardController extends Controller
{
    public function index()
    {
        $reader = auth('reader')->user();
        $cart = collect($this->getCookie());
//        return $cart;
        $inCartBooks = [];
        foreach ($cart as $item) {
            $books = Book::query()->where('id', $item['id'])
                ->when($item['option'] === 'b', function ($q) {
                    $q->with('options');
                })->when($item['option'] === 'a', function ($q) {
                    $q->with('options', function ($q) {
                        $q->where('type', 'audiobook');
                    });
                })->when($item['option'] === 'e', function ($q) {
                    $q->with('options', function ($q) {
                        $q->where('type', 'electron');
                    });
                })
                ->with('reader')
                ->get(['id', 'reader_id', 'full_name', 'slug', 'book_code', 'image', 'page', 'price', 'value', 'condition', 'created_at'])
                ->add(['option' => $item['option'], 'price' => $item['price']]);

            $inCartBooks[] = $books;

            $toCookie[] = [
                'id'  => $books[0]->id,
                'full_name' => $books[0]->full_name,
                'total_days' => null,
                'return_date' => null,
                'price' => $books[1]['price'],
                'thumbnail' => $books[0]->image(),
                'option' => $books[1]['option'],
            ];
        }

//        return $inCartBooks;
        Cookie::queue('checkout', json_encode($toCookie, JSON_UNESCAPED_UNICODE), 31 * 24 * 60);

        $registeredBooks = collect([]);
        if (auth('reader')->check()) {
            $registeredBooks = Book::query()
                ->whereHas('registrations', function (Builder $q) use ($reader) {
                    $q->where('reader_id', $reader['id']);
                })
                ->with(['registrations.user', 'reader'])
                ->get();
        }

        $likedBooks = Book::query()
            ->whereIn('id', json_decode(Cookie::get('likedBooks'), true))
            ->get();

        $data = [
            'inCartBooks' => $inCartBooks,
            'registeredBooks' => $registeredBooks,
            'likedBooks' => $likedBooks,
        ];

        return view('reader.dashboard.index')->with($data);
    }


    public function cart(Request $request): JsonResponse|RedirectResponse
    {
        try {
            $request->validate([
                'id' => ['required', 'integer', 'min:1'],
                'option' => ['required', 'string', 'in:' . implode(',', array_keys(config('settings.purchase')))],
            ]);

            if (count($request->query()) <= 0) {
                abort(404);
            }

            switch ($request->option) {
                default:
                    $price = Book::query()->where('id', $request->id)->first('price')->price();
                    break;
                case 'a':
                    $price = Option::query()->where('book_id', 200)->where('type', 'audiobook')
                        ->first('price')->price;
                    break;
                case 'e':
                    $price = Option::query()->where('book_id', 200)->where('type', 'electron')
                        ->first('price')->price;
                    break;
                case 'b':
                    $book_price = Book::query()->where('id', $request->id)->first('price')->price();
                    $option_price = Option::query()->where('book_id', $request->id)->sum('price');
                    $price = $book_price + $option_price;
                    break;
            }

            $res = $this->setCookie($request->id, $request->option, $price, remove: $request->has('remove'));

            return $request->is('/cart')
                ? redirect()->back()->with('success', trans('lang.' . $res))
                : response()->json(['status' => 'success', 'key' => $res, 'message' => trans('lang.' . $res)], 200);
        } catch (\Exception $e) {
            return $request->is('/cart')
                ? redirect()->back()->with('error', $e->getMessage())
                : response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

// type[download:electron, download:audiobook, rent_only:book, purchase:bundle], price[each:seperated]

    public function setCookie($id, $option, $price, $remove = false): string
    {
        $cart = $this->getCookie();
        $cartItem =  collect($cart)->where('id', $id)
            ->where('option', $option);

        $message = '';
        if ($cartItem->count() > 0) {
            if ($remove === true) {
                $r = array_search($cartItem->pop(), $cart);
                unset($cart[$r]);
                Cookie::queue('cart', json_encode($cart), 31*24*60);

                $message = 'removed';
            } else {
                $message = 'exists';
            }
        } else {
            $cart[] = [
                'id' => $id,
                'option' => $option,
                'price' => $price,
            ];
            $message = 'added';
            Cookie::queue('cart', json_encode($cart), 31*24*60);}
        return $message;
    }


    public function getCookie() {
        return Cookie::has('cart') ? json_decode(Cookie::get('cart'), true) : [];
    }


    public function dateControl(Request $request) {
        try {
            $request->validate([
                'receive_date_input' => ['required', 'date', 'after_or_equal:today'],
                'return_date_input' => ['sometimes', 'required', 'date', 'after:receive_date_input'],
                'total_date_input' => ['sometimes', 'required', 'integer', 'min:1', 'max:100'],
                'price_per_day' => ['sometimes', 'required', 'numeric', 'min:0'],
            ]);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }

        $receiveDate = Carbon::parse($request['receive_date_input']);
        if ($request->has('return_date_input')) {
            $returnDate = Carbon::parse($request['return_date_input']);

            return response()->json([
                'status' => 'success',
                'total_days' => $receiveDate->diffInDays($returnDate),
                'price_per_day' => number_format(intval($request->price_per_day) * $receiveDate->diffInDays($returnDate), 2),
            ], 200);
        } else {
            $totalDaysInput = intval($request['total_date_input']);

            return response()->json([
                'status' => 'success',
                'return_date' => $receiveDate->addDays($totalDaysInput)->toDateString(),
                'price_per_day' => number_format(intval($request->price_per_day) * $totalDaysInput, 2),
            ], 200);
        }
    }
}
