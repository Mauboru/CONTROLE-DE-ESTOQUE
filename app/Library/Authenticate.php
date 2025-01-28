<?php

namespace App\Library;

use App\Models\User;

class Authenticate
{
    public function authGoogle($data)
    {
        $user = new User;
        $userFound = $user->where('email', $data->email)->first();
        if (!$userFound) {
            $user->insert([
                'firstName' => $data->givenName,
                'lastName' => $data->familyName,
                'email' => $data->email,
                'avatar' => $data->picture,
            ]);
        }

        session()->put('user', $userFound);
        session()->put('auth', true);

        return redirect()->to('/');
    }

    public function logout()
    {
        session()->forget('user');
        session()->forget('auth');
        return view('main');
    }
}
