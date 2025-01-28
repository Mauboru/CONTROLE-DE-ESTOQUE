<?php

namespace App\Http\Controllers;

use App\Library\Authenticate;
use App\Library\GoogleClient;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        $googleClient = new GoogleClient;
        $googleClient->init();

        if ($googleClient->authenticated()) {
            $auth = new Authenticate();
            $auth->authGoogle($googleClient->getData());
        }

        return view('main', ['authUrl' => $googleClient->generateLink()]);
    }
}
