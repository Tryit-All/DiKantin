<?php

namespace App\Http\Controllers\API;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Mail\VerifForgotPassword;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Support\Facades\Validator;

class ApiAuth extends Controller
{

    private VerifForgotPassword $verifForgotPassword;
    // Required apikey mobile
    public function __construct()
    {
        $this->verifForgotPassword = new VerifForgotPassword();
    }

    // Controller ForgotPassrword
    public function forgotPassword(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        $emailData = $request->email;
        $RandomNumber = rand(1000, 9999);

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {

            $editCustomer = Customer::where('email', $emailData)->first();

            if ($editCustomer) {

                $dataForgot = [
                    'email' => $emailData,
                    'kode' => $RandomNumber
                ];

                $this->verifForgotPassword->dataForgot = $dataForgot;

                Mail::to($request->input('email'))->send($this->verifForgotPassword);

                Customer::where('email', $emailData)->update([
                    'kode_verified' => $RandomNumber
                ]);
                return $this->sendMassage('Success', 200, true);
            }
            return $this->sendMassage('Username tidak ditemukan', 400, false);
        }

    }

    public function verifKode(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
            'kode' => 'required',
        ]);

        $emailData = $request->email;

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {

            $editCustomer = Customer::select('kode_verified')->where('email', $emailData)->first();

            if ($editCustomer->kode_verified === $request->kode) {
                Customer::where('email', $emailData)->update([
                    'kode_verified' => null
                ]);
                return $this->sendMassage('validasi perubahan password anda berhasil', 200, true);
            }
            return $this->sendMassage('Kode yang anda masukkan salah', 400, false);
        }
    }

    public function verifPasswordNew(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'confirmPassword' => 'required',
        ]);

        $emailData = $request->email;

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {

            $editCustomer = Customer::where('email', $emailData)->first();

            if ($request->password === $request->confirmPassword) {
                if (Hash::check($request->password, $editCustomer->password)) {
                    Customer::where('email', $emailData)->update([
                        'password' => Hash::make($request->input('password'))
                    ]);
                    return $this->sendMassage('Password baru anda ada kecocokan dengan password lama anda', 400, false);
                }
                Customer::where('email', $emailData)->update([
                    'password' => Hash::make($request->input('password'))
                ]);
                return $this->sendMassage('Perubahan password anda berhasil', 200, true);
            }
            return $this->sendMassage('Password anda tidak sesuai dengan konfirmasi password', 400, false);
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
