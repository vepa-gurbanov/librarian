<?php

namespace App\Http\Controllers\Reader;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CheckoutController extends Controller
{
    public function checkoutCartItems() {
        $toCookie = [
            'id' => ['required', 'integer'],
            'full_name' => ['required', 'string'],
            'total_days' => ['nullable', 'integer'],
            'return_date' => ['nullable', 'date'],
            'price' => ['required', 'float'],
            'thumbnail' => ['required', 'image'],
            'option' => ['required', 'string'],
        ];
    }

    public function storeBillingAddress() {
        $billingAddress = [
            'location_id' => ['required'],
            'address',
            'address_optional',
            'first_name',
            'last_name',
            'phone',
            'email',
        ];
    }

    public function billingAddresses() {
        $all = Cookie::has('billing_address') ? json_decode(Cookie::get('billing_address'), true) : [];
        return response()->json(['status' => 'success', 'data' => $all]);
    }
}
