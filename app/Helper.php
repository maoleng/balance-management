<?php

use App\Lib\JWT\JWT;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;

if (!function_exists('c')) {
    function c(string $key)
    {
        return App::make($key);
    }
}

if (! function_exists('formatVND')) {
    function formatVND($money): string
    {
        return number_format($money).' <small class="text-muted small">VND</small>';
    }
}

if (! function_exists('authed')) {
    function authed()
    {
        $token = Cookie::get('token');
        if (empty($token)) {
            return null;
        }

        return c(JWT::class)->match($token);
    }
}
