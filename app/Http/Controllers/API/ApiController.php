<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Mail\VerifMail;
use App\Models\Customer;
use Hash;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Validator;

class ApiController extends Controller
{

    private VerifMail $verifMail;
    // Required apikey mobile
    public function __construct()
    {
        $this->verifMail = new VerifMail();
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

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {
            $customer = Customer::where('email', $dataEmail)->first();
            if ($customer) {
                if ($customer->email_verified == true) {
                    if (Hash::check($request->password, $customer->password)) {
                        $token = Str::random(200);
                        Customer::where('email', $dataEmail)->update([
                            'token' => $token
                        ]);
                        return $this->sendMassage($token, 200, true);
                    }
                    return $this->sendMassage('Password salah', 400, false);
                }
                return $this->sendMassage('Akun anda belum terverifikasi', 400, false);
            }
            return $this->sendMassage('Username tidak ditemukan', 400, false);
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
            $dataEmail = $request->input('email');
            $customer = Customer::where('email', $dataEmail)->first();
            if ($customer) {
                return $this->sendMassage('Akun yang anda gunakan telah terdapat pada list, lakukan aktifasi terlebih dahulu', 400, false);
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

                    $dataUser = [
                        'email' => $dataEmail,
                        'kode' => null
                    ];

                    $this->verifMail->dataUser = $dataUser;

                    \Mail::to($request->input('email'))->send($this->verifMail);
                    return response()->json([
                        'data' => "Selamat anda berhasil registrasi",
                        'code' => 200,
                        'status' => true
                    ], 200);
                    ;
                }
            }
        }

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

    public function sendMassage($text, $kode, $status)
    {
        return response()->json([
            'data' => $text,
            'code' => $kode,
            'status' => $status
        ], $kode);
    }
}