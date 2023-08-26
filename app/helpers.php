<?php

use Illuminate\Support\Facades\Cookie;

if (!function_exists('set_auth_data_before_fetch')) {
    function set_auth_data_before_fetch($phone, $token, $expiresAt, $name = null) {
        $data = [
            'name' => $name,
            'phone' => $phone,
            'token' => $token,
            'expires_at' => $expiresAt,
        ];
        Cookie::queue('auth', json_encode($data), 10);
        return true;
    }
}


