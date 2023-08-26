<?php

namespace App\Http\Controllers\Reader\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class VerificationController extends Controller
{
    public function create(Request $request): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        $phone = DB::table('password_reset_tokens')
            ->where('token', $request->token)
            ->first()->phone;

        return view('reader.auth.verification')
            ->with(['request' => $request, 'phone' => $phone]);
    }

    public function store(Request $request): JsonResponse
    {
//        return response()->json(['status' => 'error', 'message' => [
//            'name' => $request->name, 'phone' => $request->phone, 'token' => $request->token, 'code' => $request->code,
//        ]], 200);
        $validation = Validator::make($request->all(), [
            'code' => ['required', 'integer', 'between:10000, 99999'],
        ]);

        if ($validation->fails()) {
            return response()->json(['status' => 'error', 'message' =>  $validation->errors(),], 400);
        }

        if (!Cookie::has('auth')) {
            return response()->json(['status' => 'error', 'message' => trans('lang.try-request-code-again')]);
        }
        $authData = json_decode(Cookie::get('auth'), true);

        $name = $authData['name'];
        $verifiable = DB::table('password_reset_tokens')
            ->where('phone', $authData['phone'])
            ->where('token', $authData['token'])
            ->first();

//return response()->json(['status' => 'error', 'message' => $verifiable->code_expires_at < now()->format('Y-m-d H:i:s')], 400);
        if (isset($verifiable) && $verifiable->code_expires_at < Carbon::now()->toDateTimeString()) {
            return response()->json(['status' => 'error', 'message' => 'Verification code expired! Try resend.']);
//            return back()->with('error', 'Verification code expired! Try resend.');
        } elseif (isset($verifiable) && $verifiable->code !== $authData['code']) {
            return response()->json(['status' => 'error', 'message' => 'Verification code incorrect! Try again.']);
//            return back()->with('error', 'Verification code incorrect! Try again.');
        } elseif(isset($verifiable)) {
            if (isset($name)) {
                $user = Reader::create([
                    'name' => $authData['name'],
                    'phone' => $authData['phone'],
                    'password' => $request->code
                ]);

                try {
                    Auth::guard('reader')->login($user);
                    return response()->json(['status' => 'success', 'message' => 'Account successfully created!'], 201);
//                    return to_route('home')
//                        ->with('success', 'Account successfully created!');
                } catch (\Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
//                    return back()
//                        ->with('error', $e->getMessage());
                }
            } else {
                $user = Reader::where('phone', $authData['phone'])->first();
                $user->update(['password' => $request->code]);
                try {
                    Auth::guard('reader')->login($user);
                    return response()->json(['status' => 'success', 'message' => 'Logged in!'], 200);
//                    return to_route('home')
//                        ->with('success', 'Account logged in!');
                } catch (\Exception $e) {
                    return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
//                    return back()
//                        ->with('error', $e->getMessage());
                }
            }
        } else {
            return response()->json(['status' => 'error', 'message' => trans('lang.failed')]);
        }
    }

    public function resend(): JsonResponse
    {
        if (!Cookie::has('auth')) {
            return response()->json(['status' => 'error', 'message' => trans('lang.try-request-code-again')]);
        }

        $authData = json_decode(Cookie::get('auth'), true);
        $token = Str::random(60);
        $code = mt_rand(10000, 99999);
        $expiresAt = now()->addMinutes(10);
        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['phone' => $authData['phone']],
                [
                    'token' => $token,
                    'code' => $code,
                    'code_expires_at' => $expiresAt,
                ]
            );

        set_auth_data_before_fetch(phone: $authData['phone'], token: $token, expiresAt: $expiresAt, name: $authData['name']);

//        try {
        // Here:send $code to $validation['phone']
//        } catch (\Exception $e) {
        // return back()
//        }
        return response()->json([
            'key' => 'resend',
            'status' => 'success',
            'message' => trans('lang.verification-code-resend')
        ], 200);

//            return to_route('verify', ['token' => $token])
//                ->with('status', 'Verification sent!');
    }
}
