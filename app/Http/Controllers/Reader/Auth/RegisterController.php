<?php

namespace App\Http\Controllers\Reader\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;


class RegisterController extends Controller
{
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('reader.auth.register');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validation = $request->validate([
                'name' => ['required', 'string'],
                'phone' => ['required', 'integer', 'between:60000000,65999999'],
            ]);

            if (Reader::where('phone', $validation['phone'])->exists()) {
                return response()->json(['status' => 'error', 'message' => trans('lang.account_exists_try_login')], 400);
//                return back()->with('error', 'Account exist!');
            }

            $token = Str::random(60);
            $code = mt_rand(10000, 99999);
            DB::table('password_reset_tokens')
                ->updateOrInsert(
                    ['phone' => $validation['phone']],
                    [
                        'token' => $token,
                        'code' => $code,
                        'code_expires_at' => now()->addMinutes(10),
                    ]
                );

//        try {
            // Here:send $code to $validation['phone']
//        } catch (\Exception $e) {
            // return back()
//        }
            return response()->json([
                'token' => $token,
                'status' => 'success',
                'message' => trans('lang.verification-sent') . 'The code is: ' . $code . '. This is just demo'
            ], 201);

//            return to_route('verify', ['token' => $token . '?name=' . $validation['name']])
//                ->with('status', 'Verification sent!');
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
