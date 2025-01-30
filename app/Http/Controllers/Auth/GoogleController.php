<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            
            $user = User::where('email', $googleUser->email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->name,
                    'email' => $googleUser->email,
                    'password' => bcrypt(uniqid()),
                ]);
            }

            Auth::login($user);

            return redirect()->route('home');

        } catch (\Exception $e) {
            return redirect()->route('main')->with('error', 'Erro ao autenticar com o Google.');
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('main');
    }
}