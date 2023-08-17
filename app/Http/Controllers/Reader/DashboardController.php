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

class DashboardController extends Controller
{
    public function index()
    {
        $reader = auth('reader')->user();
        $cart = collect($this->getCookie());
        $inCartBooks = [];
        foreach ($cart as $item) {
            $inCartBooks[] = Book::query()->where('id', $item['id'])
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
        }

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
        $v = Validator::make($request->all(), [
            'id' => ['required', 'integer', 'min:1'],
            'option' => ['required', 'string', 'in:' . implode(',', array_keys(config('settings.purchase')))],
        ], [
            'id.required' => 'id field is required',
            'id.integer' => 'id field must be integer',
            'id.min' => 'id field must be minimum value 1',
            'option.required' => 'option field is required',
            'option.string' => 'option field  must be string',
            'option.in' => 'option field  must be in ' . implode(',', array_keys(config('settings.purchase'))),
        ]);

        if ($v->fails() or count($request->query()) <= 0) {
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

        try {
            $res = $this->setCookie($request->id, $request->option, $price, remove: $request->has('remove'));

            return $request->is('/cart')
                ? redirect()->back()->with('success', $res)
                : response()->json($res);
        } catch (\Exception $e) {
            return $request->is('/cart')
                ? redirect()->back()->with('error', $res)
                : response()->json(['error' => trans('lang.failed')], 404);
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
        $receiveDate = Carbon::parse($request['receive_date_input']);
        $totalDaysInput = $request['total_date_input'];

        return response()->json([
            'status' => 'success',
            'receive_date' => $receiveDate->format('Y-m-d H:i:s'),
        ], 200);
    }
}
