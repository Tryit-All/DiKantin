<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;

class AuthLoginController extends Controller
{
    use AuthenticatesUsers;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {

        try {

            $user = Socialite::driver('google')->user();

            $authUser = User::where('google_id', $user->id)->first();

            if ($authUser) {
                Auth::login($authUser, true);
            } else {
                if (isset($user->user['hd'])) {
                    $giveName = substr($user->user['given_name'], 0, 2);

                    if ($giveName != "E4" && $giveName != "E3") {
                        if (isset($finduser)) {
                            $pilihAdmin = User::where('id_role', 1)->first();
                            $newUser = User::update([
                                'google_id' => $user->id
                            ]);
                        }
                    }
                } else {
                    return redirect()->route('login');
                }
            }


            // if ($authUser) {
            //     Auth::login($authUser, true);
            // } else {
            //     $newUser = User::create([
            //         'username' => $user->name,
            //         'email' => $user->email,
            //         'id_role' => 1,
            //         'password' => bcrypt(Str::random(16)),
            //     ]);

            //     Auth::login($newUser, true);
            // }

            return redirect('/dashboard');

            // $user = Socialite::driver('google')->user();
            // dd($user);
            // $findEmail = User::select('email', 'password')->where('id_role', 1)->first()->toArray();

            // $temp = ['anu' => 'anu'];

            // $findEmail->push($temp);

            // return $findEmail;

            // $finduser = User::where('google_id', $user->id)->first();

            // return $finduser;

            // if (isset($finduser)) {
            //     // $credentials = $request->only('email', 'password');

            //     if (Auth::attempt($findEmail)) {
            //         // Jika login berhasil
            //         return redirect()->intended('/dashboard');

            //     }
            // } else {
            //     if (isset($user->user['hd'])) {
            //         $giveName = substr($user->user['given_name'], 0, 2);

            //         if ($giveName != "E4" && $giveName != "E3") {
            //             if (isset($finduser)) {
            //                 $pilihAdmin = User::where('id_role', 1)->first();
            //                 $newUser = User::update([
            //                     'google_id' => $user->id
            //                 ]);
            //             }
            //         }
            //     } else {
            //         return redirect()->route('login');
            //     }
            // }

            // dd($user->id);
            // if (isset($user->user['hd'])) {
            //     return redirect()->route('login');

            // } else {
            //     return "anjayy salah";
            // }

            // $credentials = $request->only('email', 'password'); 

            // dd($credentials);

            // if (Auth::attempt($credentials)) {
            //     // Jika login berhasil
            //     return redirect()->intended('/dashboard');
            // }

            // // Jika login gagal
            // return back()->withErrors([
            //     'email' => 'The provided credentials do not match our records.',
            // ]);

            // $finduser = Customer::where('google_id', $user->id)->first();
            // if ($finduser) {
            //     Auth::login($finduser);
            //     return redirect('/dashboard');
            // } else {
            //     $RandomNumber = rand(10000, 99999);
            //     $newUser = Customer::create([
            //         'id_customer' => "CUST" . $RandomNumber,
            //         'no_telepon' => '03o03oe03',
            //         'nama' => $user->name,
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
