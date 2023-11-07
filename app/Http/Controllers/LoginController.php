<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    //All providers login
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    //All providers callback
    public function handleProviderCallback($provider)
    {
        $data = Socialite::driver($provider)->user();

        $this->_registerOrLoginUser($data, $provider);
        // Return home after login
        return redirect()->intended();
    }

//Register or Login
    protected function _registerOrLoginUser($data, $provider)
    {
        //GET USER
        $user = User::where('email', $data->email)->first();

        //Create if not exists
        if (!$user) {
            //CREATE NEW USER
            $user = new User();
            $user->name = $data->name;
            $user->role = 'customer';
            $user->password = Hash::make(Str::random(8));
            $user->email = empty($data->email) ? "" : $data->email;
            $user->email_verified_at = now();
            $user->created_at = now();
        }
        $user->provider_id = $data->id;
        $user->provider_type = $provider;
        $user->remember_token = Str::random(10);
        $user->save();

        $user->tokens()->delete();
        //User Agent
        $ua = $_SERVER['HTTP_USER_AGENT'];
        $token = $user->createToken($ua, ['customer']);

        dd([
            'name' => $user->name,
            'accessToken' => $token->plainTextToken
        ]);
        //LOGIN by object user
        //Auth::login($user);
    }
}
