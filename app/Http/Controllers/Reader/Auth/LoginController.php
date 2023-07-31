<?php

namespace App\Http\Controllers\Reader\Auth;

use App\Http\Controllers\Controller;
use App\Models\Reader;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function create(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('reader.auth.login');
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validation = $request->validate([
            'phone' => ['required', 'integer', 'between:60000000,65999999'],
        ]);

        if (!Reader::where('phone', $validation['phone'])->exists()) {
            return back()->with('error', 'Account doesn\'t exist!');
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

        return to_route('verify', ['token' => $token])
            ->with('status', 'Verification sent!');
    }


    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('reader')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
