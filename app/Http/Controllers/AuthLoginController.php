<?php

namespace App\Http\Controllers;


use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class AuthLoginController extends Controller
{
    use AuthenticatesUsers;

    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    // }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        try {
            $user = Socialite::driver('google')->user();
            if (isset($user->user['hd'])) {
                return redirect("/dashboard");
            } else {
                return "anjayy salah";
            }
            // $finduser = Customer::where('google_id', $user->id)->first();
            // if ($finduser) {
            //     Auth::login($finduser);
            //     return redirect('/home');
            // } else {
            //     $newUser = Customer::create([
            //         'name' => $user->name,
            //         'email' => $user->email,
            //         'google_id' => $user->id
            //     ]);
            //     Auth::login($newUser);
            //     return redirect()->back();
            // }
        } catch (Exception $e) {
            return redirect('auth/google');
        }

    }

}
