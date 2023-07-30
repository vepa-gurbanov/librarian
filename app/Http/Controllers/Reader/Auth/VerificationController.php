<?php

namespace App\Http\Controllers\Reader\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function store(Request $request)
    {
        $validation = $request->validate([
            'name' => ['nullable', 'string'],
            'phone' => ['required', 'integer', 'between:60000000,65999999'],
            'token' => ['required'],
            'code' => ['required', 'integer', 'between:10000, 99999'],
        ]);

        $name = $request->has('name');

        $verifiable = DB::table('password_reset_tokens')
            ->where('phone', $validation['phone'])
            ->where('token', $validation['token'])
            ->first();

        if (isset($verifiable) && $verifiable->code_expires_at < now()) {
            return back()->with('error', 'Verification code expired! Try resend.');
        } elseif ($verifiable->code !== $validation['code']) {
            return back()->with('error', 'Verification code incorrect! Try again.');
        } else {
            if ($name) {
                $user = Reader::create([
                    'name' => $validation['name'],
                    'phone' => $validation['phone'],
                    'password' => $validation['code']
                ]);

                try {
                    Auth::guard('reader')->login($user);
                    return to_route('home')
                        ->with('success', 'Account successfully created!');
            } catch (\Exception $e) {
                    return back()
                        ->with('error', $e->getMessage());
                }
            } else {
                $user = Reader::where('phone', $validation['phone'])->first();
                $user->update(['password' => $validation['code']]);
                try {
                    Auth::guard('reader')->login($user);
                    return to_route('home')
                        ->with('success', 'Account logged in!');
                } catch (\Exception $e) {
                    return back()
                        ->with('error', $e->getMessage());
                }
            }
        }
    }

    public function resend(Request $request): \Illuminate\Http\RedirectResponse
    {
        {
            $validation = $request->validate([
                'name' => ['nullable', 'string'],
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

            return to_route('verify', ['token' => $token])
                ->with('status', 'Verification sent!');
        }
    }
}
