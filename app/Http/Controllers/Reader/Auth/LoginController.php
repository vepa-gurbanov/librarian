<?php

namespace App\Http\Controllers\Reader\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('reader.auth.login');
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        $validation = $request->validate([
            'phone' => ['required', 'integer', 'between:60000000,65999999'],
        ]);

        if (!Reader::where('phone', $validation['phone'])->exists()) {
            return response()->json([
                'status' => 'error',
                'message' => trans('lang.account_doesnt_exist')
            ], 400);
//            return back()->with('error', 'Account doesn\'t exist!');
        }

        $token = Str::random(60);
        $code = mt_rand(10000, 99999);
        $expiresAt = Carbon::now()->addMinutes(10);
        DB::table('password_reset_tokens')
            ->updateOrInsert(
                ['phone' => $validation['phone']],
                [
                    'token' => $token,
                    'code' => $code,
                    'code_expires_at' => $expiresAt,
                ]
            );

        set_auth_data_before_fetch(phone: $request->phone, token: $token, expiresAt: $expiresAt);
//        $this->authData(phone: $request->phone, token: $token, expiresAt: $expiresAt);
//        try {
        // Here:send $code to $validation['phone']
//        } catch (\Exception $e) {
        // return back()
//        }

        return response()->json([
            'token' => $token,
            'status' => 'success',
            'message' => trans('lang.verification-code-sent')
        ], 200);

//        return to_route('verify', ['token' => $token])
//            ->with('status', 'Verification sent!');
    }


    public function destroy(Request $request): RedirectResponse
    {
//        DB::table('password_reset_tokens')
//            ->updateOrInsert(
//                ['phone' => Auth::guard('reader')->user()['phone']],
//                ['token' => Str::random(60)]
//            );

        Auth::guard('reader')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

//    public function authData($phone, $token, $expiresAt, $name = null) {
//        $data = [
//            'name' => $name,
//            'phone' => $phone,
//            'token' => $token,
//            'expires_at' => $expiresAt,
//        ];
//        Cookie::queue('auth', json_encode($data), 10);
//        return true;
//    }


    public function fetch(Request $request): JsonResponse
    {
        if (!Cookie::has('auth')) {
            return response()->json(['status' => 'error', 'message' => trans('lang.try-request-code-again')]);
        }

        $authCreds = json_decode(Cookie::get('auth'), true);
        $exists = DB::table('password_reset_tokens')->where('phone', $authCreds['phone'])
            ->where('token', $authCreds['token'])->exists();

        if ($exists && Cookie::has('auth') && Carbon::parse($authCreds['expires_at'])->lte(Carbon::now()->toDateTimeString())) {
            return response()->json([
                'expired' => 0,
                'expiry' => Carbon::parse($authCreds['expires_at'])->addHours(5)->format('M d, Y H:i:s'),
//                'expires_at' => strval(Carbon::parse($authCreds['expires_at'])->diffAsCarbonInterval(Carbon::now())),
                'phone' => $authCreds['phone']
            ]);
        } else {
            return response()->json(['expired' => 1]);
        }
    }
}
