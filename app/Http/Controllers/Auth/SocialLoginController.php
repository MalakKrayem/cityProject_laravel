<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;
use Throwable;

class SocialLoginController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try{
        $provider_user = Socialite::driver($provider)->user();
        $user= Admin::where([
            'provider'=>$provider,
            "provider_id"=>$provider_user->id
        ])->first();
        if(!$user){
            $user = Admin::create([
                'name' => $provider_user->name,
                'email' => $provider_user->email,
                "password"=>Hash::make(Str::random(8)),
                'provider' => $provider,
                'provider_id' => $provider_user->id,
                'provider_token' => $provider_user->token,
            ]);
        }
        Auth::guard('admin')->login($user);
        return redirect()->route('home');
    }
    catch(Throwable $e){
        return redirect()->route('login','admin');
    }
    }
}
