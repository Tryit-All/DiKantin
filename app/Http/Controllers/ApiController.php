<?php

namespace App\Http\Controllers;

use App\Http\Middleware\ApiKeyMiddleware;
use App\Mail\VerifForgotPassword;
use App\Mail\VerifMail;
use App\Models\Customer;
use App\Models\Menu;
use App\Models\User;
use Hash;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class ApiController extends Controller
{

    private VerifMail $verifMail;
    private VerifForgotPassword $verifForgotPassword;
    // Required apikey mobile
    public function __construct()
    {
        $this->middleware(ApiKeyMiddleware::class);
        $this->verifMail = new VerifMail();
        $this->verifForgotPassword = new VerifForgotPassword();
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

                \Mail::to($request->input('email'))->send($this->verifForgotPassword);

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

    // public function confirmRegister(Request $request) {
    //     $response = Http::withToken($token)->post($endPointApi, [
    //         'surveyor' => Auth::user()->id,
    //         'location' => [
    //             'latitude' => $latitude,
    //             'longtitude' => $longitude,
    //         ],
    //         'answer' => [
    //             $keunggulan_umum,
    //             $keunggulan_produk,
    //             $keunggulan_kompetitor,
    //             $iklim,
    //             $event,
    //         ],
    //     ]);

    //     return $response;
    // }

    public function verified($id)
    {
        // $yourBearerToken = "DWuqUHWDUhDQUDadaq";

        // $response = Http::withHeaders([
        //     'Authorization' => 'Bearer ' . $yourBearerToken,
        // ])->post('http://127.0.0.1:8000/api/validate/verified/' . $id);

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
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', $request->segment(4) . '%')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->get(), 200, true);
        }
    }

    public function product_food(Request $request)
    {
        // dd($request->segment(3));
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', '%' . $request->segment(4) . '%')
                ->where('kategori', 'makanan')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->where('kategori', 'makanan')->get(), 200, true);
        }
    }

    public function product_drink(Request $request)
    {
        // dd($request->segment(4));
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', $request->segment(4) . '%')
                ->where('kategori', 'minuman')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->where('kategori', 'minuman')->get(), 200, true);
        }

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