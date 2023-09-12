<?php

namespace App\Http\Controllers;

use App\Lib\JWT\JWT;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

class AuthController extends Controller
{

    public function login(): View
    {
        return view('login');
    }

    public function redirect(): RedirectResponse
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback(): \Illuminate\Http\RedirectResponse
    {
        $user = Socialite::driver('google')->stateless()->user();
        if ($user->email !== env('AUTH_EMAIL')) {
            return redirect()->back();
        }
        $token = c(JWT::class)->encode([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);

        return redirect()->route('index')->cookie('token', $token, 60 * 24 * 365 * 5);
    }

}
