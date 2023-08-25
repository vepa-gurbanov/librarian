<?php

namespace App\Http\Controllers\Reader\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;
use function PHPUnit\Framework\isJson;

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
        $validation = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => ['sometimes', 'string'],
            'phone' => ['required', 'integer', 'between:60000000,65999999'],
            'token' => ['sometimes'],
            'code' => ['required', 'integer', 'between:10000, 99999'],
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 'error',
                'message' =>  $validation->errors(),
            ], 400);
        }

        $name = $request->has('name');
        $verifiable = DB::table('password_reset_tokens')
            ->where('phone', intval($request->phone))
//            ->where('code', intval($request->code))
            ->where('token', $request->token)
            ->first();

//return response()->json(['status' => 'error', 'message' => $verifiable->code_expires_at < now()->format('Y-m-d H:i:s')], 400);
        if (isset($verifiable) && $verifiable->code_expires_at < Carbon::now()->toDateTimeString()) {
            return response()->json(['status' => 'error', 'message' => 'Verification code expired! Try resend.']);
//            return back()->with('error', 'Verification code expired! Try resend.');
        } elseif (isset($verifiable) && $verifiable->code !== $request->code) {
            return response()->json(['status' => 'error', 'message' => 'Verification code incorrect! Try again.']);
//            return back()->with('error', 'Verification code incorrect! Try again.');
        } elseif(isset($verifiable)) {
            if ($name) {
                $user = Reader::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
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
                $user = Reader::where('phone', $request->phone)->first();
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

    public function resend(Request $request): JsonResponse
    {
        {
            $validation = $request->validate([
                'phone' => ['required', 'integer', 'between:60000000,65999999'],
            ]);

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
                'key' => 'resend',
                'status' => 'success',
                'message' => trans('lang.verification-code-resend')
            ], 200);

//            return to_route('verify', ['token' => $token])
//                ->with('status', 'Verification sent!');
        }
    }
}
