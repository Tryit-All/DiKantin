<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ApiKeyMiddleware;
use App\Mail\VerifMail;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class ApiController extends Controller
{
    // Required apikey mobile
    public function __construct()
    {
        $this->middleware(ApiKeyMiddleware::class);
    }

    // Controller Login
    public function loginUser(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $dataEmail = $request->email;
        $dataEmailVerif = $request->email_verified;

        if (!$request->apikey) {
            return $this->sendMassage('API Key tidak sesuai', 400, false);
        } else {
            if ($validadte->fails()) {
                return $this->sendMassage($validadte->errors()->first(), 400, false);
            } else {
                if ($this->apikey === $request->apikey) {
                    $customer = Customer::where('email', $dataEmail)->first();
                    if ($customer) {
                        if ($customer->email_verified === true) {
                            if (Hash::check($request->password, $customer->password)) {
                                return $this->sendMassage($customer->nama, 200, true);
                            }
                            return $this->sendMassage('Password salah', 400, false);
                        }
                        return $this->sendMassage('Akun anda belum terverifikasi', 400, false);
                    }
                    return $this->sendMassage('Username tidak ditemukan', 400, false);
                }
                return $this->sendMassage("APIkey tidak ditemukann", 400, false);
            }
        }
    }

    // Controller Register
    public function registerUser(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'nama' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);



        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {
            $isRegister = Customer::create([
                'id_customer' => "Cust " . Str::uuid()->toString(),
                'nama' => $request->input('nama'),
                'no_telepon' => $request->input('no_telepon'),
                'alamat' => $request->input('alamat'),
                'email' => $request->input('email'),
                'password' => Hash::make($request->input('password')),
            ]);

            if (isset($isRegister)) {
                \Mail::to($request->input('email'))->send(new VerifMail(['email' => $request->input('email')]));
                return response()->json([
                    'data' => "Selamat anda berhasil registrasi",
                    'code' => 200,
                    'status' => true
                ], 200);
                ;
            }
        }

    }

    public function forgotPassword(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        $emailData = $request->email;

        if ($this->apikey === $request->apikey) {
            $editCustomer = Customer::where("email", $emailData)->first();
            // dd($editCustomer);
            if ($editCustomer) {
                $editCustomer->update([
                    'password' => Hash::make($request->input('password'))
                ]);
                return $this->sendMassage('Success', 200, true);
            }
            return $this->sendMassage('Username tidak ditemukan', 400, false);
        }
        return $this->sendMassage("APIkey tidak ditemukann", 400, false);

    }

    public function verified($id)
    {
        $editCustomer = Customer::where("email", $id)->first()->update([
            'email_verified' => true
        ]);

        if ($editCustomer) {
            $hasil = Customer::where("email", $id)->first();
            return response()->json([
                'data' => $hasil->email_verified,
                'code' => 200,
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'data' => null,
                'code' => 400,
                'status' => false
            ], 400);
        }
    }

    // Controller Product
    public function product(Request $request)
    {
        if (!$request->apikey) {
            return $this->sendMassage('API Key tidak sesuai', 400, false);
        } else {
            if ($this->apikey === $request->apikey) {
                return
                    $this->sendMassage(Menu::all(), 200, true);
                ;
            }
        }
        return $this->sendMassage('API Key tidak sesuai', 200, false);
    }

    // Function Massage
    public function sendMassage($text, $kode, $status)
    {
        return response()->json([
            'data' => $text,
            'code' => $kode,
            'status' => $status
        ], $kode);
    }
}