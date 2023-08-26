<?php

namespace App\Http\Controllers\Reader\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;


class RegisterController extends Controller
{
    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $validation = Validator::make($request->all(), [
                'name' => ['required', 'string'],
                'phone' => ['required', 'integer', 'between:60000000,65999999'],
            ]);

            if ($validation->fails()) {
                return response()->json(['status' => 'error', 'message' =>  $validation->errors(),], 400);
            }

            if (Reader::where('phone', $request->phone)->exists()) {
                return response()->json(['status' => 'error', 'message' => trans('lang.account_exists_try_login')], 400);
            }

            $token = Str::random(60);
            $code = mt_rand(10000, 99999);
            $expiresAt = Carbon::now()->addMinutes(10);
            DB::table('password_reset_tokens')
                ->updateOrInsert(
                    ['phone' => $request->phone],
                    [
                        'token' => $token,
                        'code' => $code,
                        'code_expires_at' => $expiresAt,
                    ]
                );

            set_auth_data_before_fetch(phone: $request->phone, token: $token, expiresAt: $expiresAt, name: $request->name);

//        try {
            // Here:send $code to $request->phone
//        } catch (\Exception $e) {
            // return back()
//        }
            return response()->json([
                'status' => 'success',
                'message' => trans('lang.verification-sent') . 'The code is: ' . $code . '. This is just demo'
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }
}
