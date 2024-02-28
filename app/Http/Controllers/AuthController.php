<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = User::query()->create([
            'name' => $user->name,
            'email' => $user->email,
            'image' => $user->avatar,
            'created_at' => now(),
        ]);
        Auth::login($user, true);

        return redirect()->route('index');
    }

}
