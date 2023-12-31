<?php

namespace App\Http\Controllers\API;

use App\Models\Kantin;
use Http;
use App\Models\Menu;
use App\Models\User;
use App\Models\Kurir;
use App\Mail\VerifMail;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Http\Middleware\ApiKeyMiddleware;

use App\Service\NotificationService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Messaging\Notification;

class ApiController extends Controller
{

    private VerifMail $verifMail;
    private NotificationService $service;
    // Required apikey mobile
    public function __construct()
    {
        $this->verifMail = new VerifMail();
        $this->service = new NotificationService();
    }

    // Controller Login
    public function loginUser(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'token_fcm' => 'required',
        ]);

        $dataEmail = $request->email;
        $dataTokenFcm = $request->token_fcm;

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {
            $customer = Customer::where('email', $dataEmail)->first();
            if ($customer) {
                if ($customer->email_verified == true) {
                    if (Hash::check($request->password, $customer->password)) {
                        $token = Str::random(200);
                        Customer::where('email', $dataEmail)->update([
                            'token' => $token,
                            'token_fcm' => $dataTokenFcm,
                        ]);
                        $dataCustomer = Customer::where('email', $dataEmail)->first();
                        return $this->sendMassage($dataCustomer, 200, true);
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

        $RandomNumber = rand(10000, 99999);

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {
            $dataEmail = $request->input('email');
            $customer = Customer::where('email', $dataEmail)->first();
            if ($customer) {
                return $this->sendMassage('Akun yang anda gunakan telah terdapat pada list, lakukan aktifasi terlebih dahulu', 400, false);
            } else {

                $isRegister = Customer::create([
                    'id_customer' => "CUST" . $RandomNumber,
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

                    Mail::to($request->input('email'))->send($this->verifMail);
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
            return view('email.notifikasiEmail', compact('hasil'))->with([
                'data' => $hasil->email_verified,
                'code' => 200,
                'status' => true
            ]);
            // return view('email.notifikasiEmail', compact('hasil'));
            // return response()->json([
            //     'data' => $hasil->email_verified,
            //     'code' => 200,
            //     'status' => true
            // ], 200);
        } else {
            $hasil = "Kesalahan akun";
            return view('email.notifikasiEmail')->with([
                'data' => 'salah',
                'code' => 400,
                'status' => false
            ]);
            // return view('email.notifikasiEmail', compact('hasil'));
            // return response()->json([
            //     'data' => 'salah',
            //     'code' => 400,
            //     'status' => false
            // ], 400);
        }
    }

    public function getTokenCustomer(Request $request)
    {
        $idCustomer = $request->input('id_customer');
        // dd($idCustomer);

        if (!isset($idCustomer)) {
            return $this->sendMassage("ID Customer tidak sesuai", 401, false);
        }

        $dataCustomer = Customer::where('id_customer', $idCustomer)->first();

        if (!$dataCustomer) {
            return $this->sendMassage("Data Customer tidak ditemukan", 404, false);
        }

        return $this->sendMassage($dataCustomer, 200, true);

    }

    // Controller Kurir
    public function loginKurir(Request $request)
    {
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'token_fcm' => 'required',
        ]);

        $dataEmail = $request->email;
        $dataTokenFcm = $request->token_fcm;

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {
            $kurir = Kurir::where('email', $dataEmail)->first();
            if ($kurir) {
                if (Hash::check($request->password, $kurir->password)) {
                    $token = Str::random(200);
                    Kurir::where('email', $dataEmail)->update([
                        'token' => $token,
                        'token_fcm' => $dataTokenFcm,
                    ]);
                    $dataKurir = Kurir::where('email', $dataEmail)->first();
                    return $this->sendMassage($dataKurir, 200, true);
                }
                return $this->sendMassage('Password salah', 400, false);
            }
            return $this->sendMassage('Username tidak ditemukan', 400, false);
        }
    }

    public function getTokenKurir(Request $request)
    {
        $idKurir = $request->input('id_kurir');

        if (!isset($idKurir)) {
            return $this->sendMassage("ID Kurir tidak sesuai", 401, false);
        }

        $dataKurir = Kurir::where('id_kurir', $idKurir)->first();

        if (!$dataKurir) {
            return $this->sendMassage("Data Kurir tidak ditemukan", 404, false);
        }

        return $this->sendMassage($dataKurir, 200, true);
    }
    // End Controller Kurir

    // Controller Kantin
    public function loginKantin(Request $request)
    {
        // return 'anu';
        $validadte = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'token_fcm' => 'required',
        ]);

        $dataEmail = $request->email;
        $dataTokenFcm = $request->token_fcm;

        if ($validadte->fails()) {
            return $this->sendMassage($validadte->errors()->first(), 400, false);
        } else {
            $kantin = User::where('email', $dataEmail)->first();
            if ($kantin) {
                if ($kantin->id_role == 3) {
                    if (Hash::check($request->password, $kantin->password)) {
                        $token = Str::random(200);
                        User::where('email', $dataEmail)->update([
                            'token' => $token,
                            'token_fcm' => $dataTokenFcm,
                        ]);
                        $dataKurir = User::with(['Kantin' => function ($query) {
                            $query->select('id_kantin', 'status');
                        }])->where('email', $dataEmail)->first();
                        return $this->sendMassage($dataKurir, 200, true);
                    }
                    return $this->sendMassage('Password salah', 400, false);
                }
                return $this->sendMassage('Tidak sesuai roles', 403, false);
            }
            return $this->sendMassage('Email atau password anda salah', 401, false);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json(['message' => 'Logout successful'], 200);
    }

    public function editProfile(Request $request)
    {
        $token = $request->bearerToken();

        $kurir = Kurir::where('token', $token)->first();

        $dataEmail = $kurir->email;

        if (isset($kurir)) {
            if ($kurir->status == true) {
                Kurir::where('email', $dataEmail)->update([
                    'status' => false
                ]);
                $selectStatus = Kurir::select('status')->where('email', $dataEmail)->first();
                return $this->sendMassage($selectStatus->status, 200, true);
            } else {
                Kurir::where('email', $dataEmail)->update([
                    'status' => true
                ]);
                $selectStatus = Kurir::select('status')->where('email', $dataEmail)->first();
                return $this->sendMassage($selectStatus->status, 200, true);
            }
        }
    }

    public function getTokenKantin(Request $request)
    {
        $idKantin = $request->input('id_kantin');

        if (!isset($idKantin)) {
            return $this->sendMassage("ID Kantin tidak sesuai", 401, false);
        }

        $dataKantin = User::where('id_kantin', $idKantin)->first();

        if (!$dataKantin) {
            return $this->sendMassage("Data Kantin tidak ditemukan", 404, false);
        }

        return $this->sendMassage($dataKantin, 200, true);

    }
    // End Controller Kantin

    public function konfirmasiPesanan(Request $request)
    {
        // dd("konfirm");

        $kode = $request->kode;
        $kantin = $request->kantin;
        $kurir = $request->kurir;
        $kodeMenu = $request->kode_menu;
        $customer = $request->customer;
        $kodeTransaksi = $request->kode_tr;
        $buktiPengiriman = $request->bukti_pengiriman;

        $transaksi = Transaksi::with('detail_transaksi.Menu.Kantin')->where('kode_tr', $kodeTransaksi)->first();

        $transaksiCustomer = Transaksi::with('Customer')->where('kode_tr', $kodeTransaksi)->first();

        $valid = false;
        $valid2 = false;

        if ($kode == '0') {
            // 

            $statusPesanan = $transaksi->status_pesanan;
            $statusKonfirm = $transaksi->status_konfirm;

            if ($statusKonfirm != '2' && $statusKonfirm != '3' && $statusPesanan != '2' && $statusPesanan != '3') {
                if (isset($customer)) {
                    Transaksi::where('id_customer', $customer)->where('kode_tr', $kodeTransaksi)->delete();
                    return $this->sendMassage("Kode transaksi $kodeTransaksi telah berhasil di hapus", 200, true);
                }
                return $this->sendMassage("Id customer tidak valid", 400, false);
            }
            return $this->sendMassage('error validasi', 400, false);

        } elseif ($kode == '1') {
            if (isset($kantin, $kodeMenu, $kodeTransaksi)) {
                $statusKonfirm = DetailTransaksi::join('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
                    ->select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu', 'menu.id_kantin')
                    ->where('detail_transaksi.kode_tr', $kodeTransaksi)
                    ->where('menu.id_kantin', $kantin)
                    ->where('detail_transaksi.kode_menu', $kodeMenu)
                    ->first();
                // dd($statusKonfirm);
                if (isset($statusKonfirm)) {
                    $kodeIdKantin = $statusKonfirm->id_kantin;
                    $kodeMenus = $statusKonfirm->kode_menu;
                    $status = $statusKonfirm->status_konfirm;

                    if ($status == "menunggu" && $kodeIdKantin == $kantin) {
                        $konfirm_status = "memasak";
                        DetailTransaksi::where('kode_menu', $kodeMenus)->where('kode_tr', $kodeTransaksi)->update([
                            'status_konfirm' => $konfirm_status,
                        ]);
                        if (isset($transaksiCustomer->Customer->token_fcm)) {
                            $this->service->sendNotifToSpesidicToken($transaksi->Customer->token_fcm, Notification::create("Pesanan sedang diproses", "Kantin Sedang memasak pesanan kamu"), [
                                'kode_tr' => $kodeTransaksi,
                            ]);
                        } else {
                            // user belum memiliki token
                        }
                        // kirim notif ke customer menjadi memasak
                        return $this->sendMassage("Pesanan Sedang diproses", 200, true);
                    } else {
                        return $this->sendMassage('Anda sudah memproses pesanan', 400, false);
                    }
                }
                return $this->sendMassage('Kode transaksi tidak sesuai', 404, false);
            }

            $validatePesanan = DetailTransaksi::select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu')->where('detail_transaksi.kode_tr', $kodeTransaksi)->get()->toArray();

            foreach ($validatePesanan as $key => $value) {
                if ($value['status_konfirm'] != null) {
                    if ($value['status_konfirm'] == 'memasak') {
                        $valid = true;
                    } else {
                        $valid = false;
                        break;
                    }
                } else {
                    $valid = false;
                    break;
                }
            }

            $temp = [
                'valid' => $valid
            ];

            array_push($validatePesanan, $temp);

            if ($valid == true) {
                Transaksi::where('kode_tr', $kodeTransaksi)->update([
                    'status_pesanan' => '2',
                ]);
            }

            return $validatePesanan;
            // return $this->sendMassage('status konfirm = 1, status pesanan = 2, status pengiriman = proses', 200, true);
        } elseif ($kode == '2') {

            if (isset($kantin, $kodeMenu, $kodeTransaksi)) {
                $statusKonfirm = DetailTransaksi::join('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
                    ->select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu', 'menu.id_kantin')
                    ->where('detail_transaksi.kode_tr', $kodeTransaksi)
                    ->where('menu.id_kantin', $kantin)
                    ->where('detail_transaksi.kode_menu', $kodeMenu)
                    ->first();

                if (isset($statusKonfirm)) {
                    $kodeIdKantin = $statusKonfirm->id_kantin;
                    $kodeMenu = $statusKonfirm->kode_menu;
                    $status = $statusKonfirm->status_konfirm;

                    if ($status == "memasak" && $kodeIdKantin == $kantin) {
                        $konfirm_status = "selesai";
                        DetailTransaksi::where('kode_menu', $kodeMenu)->where('kode_tr', $kodeTransaksi)->update([
                            'status_konfirm' => $konfirm_status,
                        ]);
                        $detailTransaksi = DetailTransaksi::where('kode_menu', $kodeMenu)->where('kode_tr', $kodeTransaksi)->get();
                        foreach ($detailTransaksi as $key => $value) {
                            # code...
                            $subTotal = $value->subtotal_hargapokok;
                            $kantinData = $value->menu->kantin;
                            $kantinData->total_saldo += $subTotal;
                            $kantinData->save();
                        }
                    } else {
                        return $this->sendMassage('Anda sudah memproses pesanan', 400, false);
                    }
                }
            }

            $validatePesanan = DetailTransaksi::select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu')->where('detail_transaksi.kode_tr', $kodeTransaksi)->get()->toArray();

            foreach ($validatePesanan as $key => $value) {
                if ($value['status_konfirm'] != null) {
                    if ($value['status_konfirm'] == 'selesai') {
                        $valid = true;
                    } else {
                        $valid = false;
                        break;
                    }
                } else {
                    $valid = false;
                    break;
                }
            }

            $temp = [
                'valid' => $valid
            ];

            array_push($validatePesanan, $temp);

            if ($valid == true) {
                Transaksi::where('kode_tr', $kodeTransaksi)->update([
                    'id_kurir' => '3219',
                    'status_pesanan' => '3',
                ]);
                $kurir = Kurir::find('3219');
                if (isset($transaksiCustomer->Customer->token_fcm)) {
                    $this->service->sendNotifToSpesidicToken($transaksi->Customer->token_fcm, Notification::create("Pesanan Sudah Dimasak", "Pesananmu Sedang Menunggu Kurir mohon bersabar"), [
                        'kode_tr' => $kodeTransaksi,
                    ]);
                } else {
                    // user belum memiliki token
                }

                if (isset($kurir->token_fcm)) {
                    $this->service->sendNotifToSpesidicToken($kurir->token_fcm, Notification::create("Ada Pesanan", "Segera ambil pesanan kamu dan antar ke customer yaa"), [
                        'kode_tr' => $kodeTransaksi,
                    ]);
                }

            }

            return $validatePesanan;

            // KURIR OTOMATIS

            // $listKodeMenu = collect($transaksi['detail_transaksi'])->pluck('kode_menu')->toArray();

            // // return $this->sendMassage($listKodeMenu, 200, true);
            // $listIdkantin = Menu::select('id_kantin')->whereIn('id_menu', $listKodeMenu)->get();
            // // return $this->sendMassage($listIdkantin, 200, true);
            // $selectKurir = Kurir::select('kurir.id_kurir')->where('status', 1)->get()->toArray();


            // foreach ($listIdkantin as $key => $value) {
            //     # code...
            //     $statusKonfirm = DetailTransaksi::select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu')
            //         ->join('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
            //         ->join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')
            //         ->where('detail_transaksi.kode_tr', $kodeTransaksi)
            //         ->where('kantin.id_kantin', $value->id_kantin)
            //         ->where('detail_transaksi.kode_menu', $kodeMenu)
            //         ->first();
            //     if (isset($statusKonfirm)) {
            //         if (strtolower($statusKonfirm->status_konfirm) != 'memasak' && strtolower($statusKonfirm->status_konfirm) != 'selesai') {
            //             return $this->sendMassage("Pesanan Ada yang belum memasak", 400, false);
            //         }
            //     }
            // }

            // $statusKonfirm = DetailTransaksi::select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu')
            //     ->join('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
            //     ->join('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')
            //     ->where('detail_transaksi.kode_tr', $kodeTransaksi)
            //     ->where('kantin.id_kantin', $kantin)
            //     ->where('detail_transaksi.kode_menu', $kodeMenu)
            //     ->first();
            // if ($statusKonfirm->status_konfirm == 'selesai') {
            //     return $this->sendMassage("Kamu sudah menyelesaikan pesanan ini", 400, false);
            // } else {
            //     DetailTransaksi::where('kode_menu', $kodeMenu)->where('kode_tr', $kodeTransaksi)->update([
            //         'status_konfirm' => 'selesai',
            //     ]);
            // }

            // $listKurir = [];
            // $listKurirPakaiDahulu = [];
            // $listKurirPakai = [];
            // $kurirTerpilih = [];

            // $validatePesanan = DetailTransaksi::select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu')->where('detail_transaksi.kode_tr', $kodeTransaksi)->get()->toArray();

            // foreach ($validatePesanan as $key => $value) {
            //     if ($value['status_konfirm'] != null) {
            //         if ($value['status_konfirm'] == 'selesai') {
            //             $valid2 = true;
            //         } else {
            //             $valid2 = false;
            //             break;
            //         }
            //     } else {
            //         $valid2 = false;
            //         break;
            //     }
            // }

            // $temp = [
            //     'valid' => $valid2
            // ];

            // array_push($validatePesanan, $temp);

            // foreach ($selectKurir as $key => $value) {
            //     $kurirFree = Kurir::select('kurir.id_kurir')->join('transaksi', 'kurir.id_kurir', '=', 'transaksi.id_kurir')->where('transaksi.id_kurir', $value['id_kurir'])->get();

            //     if ($kurirFree->isEmpty()) {
            //         $status = 'free';
            //     } else {
            //         $kurirAfterTransaction = Transaksi::with('detail_transaksi.Menu')->where('id_kurir', $value['id_kurir'])->get();

            //         if (sizeof($kurirAfterTransaction) != 0) {

            //             foreach ($kurirAfterTransaction as $key => $value) {
            //                 $status_konfirm = $value['status_konfirm'];
            //                 $status_pesanan = $value['status_pesanan'];
            //                 $status_pengiriman = $value['status_pengiriman'];

            //                 $status = null;

            //                 if ($status_konfirm == '3' && $status_pesanan == '3' && $status_pengiriman == 'terima') {
            //                     $status = 'sudah mendapatkan transaksi';
            //                 } else {
            //                     $status = 'busy';
            //                 }

            //             }

            //         }
            //     }

            //     $temp = [
            //         'id_kurir' => $value['id_kurir'],
            //         'status' => $status,
            //     ];

            //     $listKurir[] = $temp;
            // }


            // foreach ($listKurir as $key => $value) {
            //     if ($value['status'] == 'free') {
            //         $temp = [
            //             'id_kurir' => $value['id_kurir'],
            //             'status' => $value['status'],
            //         ];

            //         $listKurirPakaiDahulu[] = $temp;
            //     }
            // }

            // foreach ($listKurir as $key => $value) {
            //     if ($value['status'] == 'sudah mendapatkan transaksi') {

            //         $temp = [
            //             'id_kurir' => $value['id_kurir'],
            //             'status' => $value['status'],
            //         ];

            //         $listKurirPakai[] = $temp;
            //     }
            // }

            // if (sizeof($listKurirPakai) != 0 || sizeof($listKurirPakaiDahulu) != 0) {
            //     if (sizeof($listKurirPakaiDahulu) != 0) {
            //         $kurirTerpilih = Arr::get($listKurirPakaiDahulu, array_rand($listKurirPakaiDahulu, 1));
            //     } else {
            //         $kurirTerpilih = Arr::get($listKurirPakai, array_rand($listKurirPakai, 1));
            //     }
            // } else {
            //     return $this->sendMassage('Tidak ada Kurir', 400, false);
            // }

            // if ($valid2 == true) {
            //     Transaksi::where('kode_tr', $kodeTransaksi)->update([
            //         'id_kurir' => $kurirTerpilih['id_kurir'],
            //         'status_pesanan' => '3',
            //     ]);
            //     if (isset($transaksiCustomer->Customer->token_fcm)) {
            //         $this->service->sendNotifToSpesidicToken($transaksi->Customer->token_fcm, Notification::create("Pesanan Sudah Dimasak", "Pesananmu Sedang Menunggu Kurir mohon bersabar"), [
            //             'kode_tr' => $kodeTransaksi,
            //         ]);
            //     } else {
            //         // user belum memiliki token
            //     }
            // }

            // return $validatePesanan;
            // return $this->sendMassage('status konfirm = 1, status pesanan = 3, status pengiriman = proses', 400, true);
        } elseif ($kode == '3') {

            $kode_tr = $transaksi->kode_tr;
            $statusPesanan = $transaksi->status_pesanan;
            $statusKonfirm = $transaksi->status_konfirm;

            $idKurir = $transaksi->id_kurir;
            $idKurir2 = Kurir::select('id_kurir')->where('token', $kurir)->first(); // sementara bolo
            $kurir2 = $idKurir2->id_kurir; // sementara bolo

            if ($kode_tr == $kodeTransaksi) {
                if ($idKurir == $kurir2 && $statusKonfirm == '1' && $statusPesanan == '3') {

                    Transaksi::where('kode_tr', $kodeTransaksi)->update([
                        'status_konfirm' => '2',
                        'status_pengiriman' => 'kirim'
                    ]);

                    if (isset($transaksiCustomer->Customer->token_fcm)) {
                        $this->service->sendNotifToSpesidicToken($transaksi->Customer->token_fcm, Notification::create("Pesanan Selesai", "Pesananmu Sedang Menunggu Kurir mohon bersabar"), [
                            'kode_tr' => $kodeTransaksi,
                        ]);
                    } else {
                        // user belum memiliki token
                    }

                    return $this->sendMassage('Pesanan dikirim', 200, true);
                }
                return $this->sendMassage('Kode transaksi tidak sesuai', 400, true);
            }
            // return $this->sendMassage('status konfirm = 2, status pesanan = 3, status pengiriman = kirim', 400, true);
        } elseif ($kode == '4') {
            $kode_tr = $transaksi->kode_tr;
            // return $kode_tr;
            $statusPesanan = $transaksi->status_pesanan;
            $statusKonfirm = $transaksi->status_konfirm;
            $idKurir = $transaksi->id_kurir;

            $idKurir2 = Kurir::select('id_kurir')->where('token', $kurir)->first(); // sementara bolo
            $kurirToken = Kurir::where('token', $kurir)->first();
            $kurir2 = $idKurir2->id_kurir; // sementara bolo
            $kantinData = User::where('id_kantin', $kantin)->first();
            if ($kode_tr == $kodeTransaksi) {
                if ($idKurir == $kurir2 && $statusKonfirm == '2' && $statusPesanan == '3') {
                    Transaksi::where('kode_tr', $kodeTransaksi)->update([
                        'status_konfirm' => '3',
                        'status_pengiriman' => 'terima',
                        'bukti_pengiriman' => 'Done'
                    ]);
                    $detailTransaksiKantin = DetailTransaksi::where('kode_tr', $kodeTransaksi)->with('menu')->get();
                    foreach ($detailTransaksiKantin as $key => $value) {
                        # code...
                        $subTotal = $value->subtotal_hargapokok;
                        $kantinData = $value->menu->kantin;
                        $kantinData->total_saldo += $subTotal;
                        $kantinData->save();
                    }
                    $kurirToken->total_saldo += 3000;
                    $kurirToken->save();

                    if (isset($kantinData->fcm_token)) {
                        $this->service->sendNotifToSpesidicToken($kantinData->fcm_token, Notification::create("Pesanan Diterima", "Pesananmu Sudah diterima oleh customer"), [
                            'kode_tr' => $kodeTransaksi,
                        ]);
                    } else {
                        // user belum memiliki token
                    }
                    return $this->sendMassage('Pesanan diterima', 200, true);
                }
                return $this->sendMassage('Kode transaksi tidak sesuai', 400, true);
            }
            // return $this->sendMassage('status konfirm = 2, status pesanan = 3, status pengiriman = terima', 400, true);
        } elseif ($kode == '5') {

            $kode_tr = $transaksi->kode_tr;
            $statusPesanan = $transaksi->status_pesanan;
            $statusKonfirm = $transaksi->status_konfirm;

            if ($kode_tr == $kodeTransaksi) {
                if ($kode_tr == $buktiPengiriman && $statusKonfirm == '2' && $statusPesanan == '3') {
                    Transaksi::where('kode_tr', $kodeTransaksi)->update([
                        'status_konfirm' => '3',
                    ]);
                    return $this->sendMassage('Pesanan selesai', 200, true);
                }
                return $this->sendMassage('Kode transaksi tidak sesuai', 400, false);
            }
            // return $this->sendMassage('status konfirm = 3, status pesanan = 3, status pengiriman = terima', 400, true);
        } elseif ($kode == '6') {
            if (isset($kantin, $kodeMenu, $kodeTransaksi)) {
                $statusKonfirm = DetailTransaksi::join('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
                    ->select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu', 'menu.id_kantin')
                    ->where('detail_transaksi.kode_tr', $kodeTransaksi)
                    ->where('menu.id_kantin', $kantin)
                    ->where('detail_transaksi.kode_menu', $kodeMenu)
                    ->first();

                if (isset($statusKonfirm)) {
                    $kodeIdKantin = $statusKonfirm->id_kantin;
                    $kodeMenu = $statusKonfirm->kode_menu;
                    $status = $statusKonfirm->status_konfirm;
                  
                    if ($status == "memasak" && $kodeIdKantin == $kantin) {
                        $konfirm_status = "selesai";
                        DetailTransaksi::where('kode_menu', $kodeMenu)->where('kode_tr', $kodeTransaksi)->update([
                            'status_konfirm' => $konfirm_status,
                        ]);
                    } else {
                        return $this->sendMassage('Anda sudah memproses pesanan', 400, false);
                    }
                }
            }

            $validatePesanan = DetailTransaksi::select('detail_transaksi.status_konfirm', 'detail_transaksi.kode_menu')->where('detail_transaksi.kode_tr', $kodeTransaksi)->get()->toArray();

            foreach ($validatePesanan as $key => $value) {
                if ($value['status_konfirm'] != null) {
                    if ($value['status_konfirm'] == 'selesai') {
                        $valid = true;
                    } else {
                        $valid = false;
                        break;
                    }
                } else {
                    $valid = false;
                    break;
                }
            }

            $temp = [
                'valid' => $valid
            ];

            array_push($validatePesanan, $temp);

            if ($valid == true) {
                Transaksi::where('kode_tr', $kodeTransaksi)->update([
                    'status_pesanan' => '3',
                    'status_konfirm' => '3',
                    'status_pengiriman' => 'terima'
                ]);
                $dataTransaksi = Transaksi::where('kode_tr' , $kodeTransaksi)->with('detail_transaksi' , 'detail_transaksi.menu.kantin')->first();
                foreach ($dataTransaksi->detail_transaksi as $key => $value) {
                    # code...
                    $currentCanteen = $value->menu->kantin;
                    $currentCanteen->total_saldo += $value->subtotal_hargapokok;
                    $currentCanteen->save();
                }
            }
            return $validatePesanan;
            // return $this->sendMassage('status konfirm = 3, status pesanan = 3, status pengiriman = terima', 400, true);
        }
    }   

    public function editCustomer(Request $request)
    {
        // Mencari user dari token yang didapatkan dari request
        $token = $request->bearerToken();
        $user = Customer::where('token', $token)->first();

        if ($user) {
            // Periksa apakah ada perubahan nilai sebelum menyimpan
            $nama = $request->input('nama');
            $email = $request->input('email');
            $no_telepon = $request->input('no_telepon');
            $alamat = $request->input('alamat');

            if (!empty($nama)) {
                $user->nama = $nama;
            }

            if (!empty($email)) {
                $user->email = $email;
            }

            if (!empty($no_telepon)) {
                $user->no_telepon = $no_telepon;
            }

            if (!empty($alamat)) {
                $user->alamat = $alamat;
            }

            // Simpan hanya jika ada perubahan nilai
            if ($user->isDirty()) {
                $user->save();
                return $this->sendMassage('Data terupdate', 200, true);
            } else {
                return $this->sendMassage('Tidak ada perubahan data', 200, true);
            }
        } else {
            return $this->sendMassage('Pelanggan tidak ditemukan', 400, false);
        }
    }

    public function kurirImage(Request $request)
    {
        $token = $request->bearerToken();
        $kurir = Kurir::where('token', $token)->first();

        if (!$token) {
            return $this->sendMassage('Tolong masukkan token', 401, false);
        }

        if ($request->hasFile('foto')) {
            $oldFilePath = public_path($kurir->foto);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }

            $originalFilename = $request->file('foto')->getClientOriginalName();
            $extension = $request->file('foto')->getClientOriginalExtension();
            $newFilename = 'kurir' . '/' . Str::random(30) . '.' . $extension;
            $request->file('foto')->move(public_path('kurir/'), $newFilename);

            $kurir->foto = $newFilename;
            $kurir->save();

            return $this->sendMassage('Foto Profile terupdate', 200, true);
        }
    }

    public function profileImage(Request $request)
    {
        $token = $request->bearerToken();
        $user = Customer::where('token', $token)->first();

        if (!$token) {
            return $this->sendMassage('Tolong masukkan token', 401, false);
        }

        if ($request->hasFile('foto')) {
            $file = $request->file('foto');

            // Check if the file size is greater than 2MB
            $maxFileSize = 2 * 1024 * 1024; // 2MB in bytes
            if ($file->getSize() > $maxFileSize) {
                return $this->sendMassage('Ukuran file tidak boleh lebih dari 2MB', 200, false);
            }

            $oldFilePath = public_path($user->foto);
            if (File::exists($oldFilePath)) {
                File::delete($oldFilePath);
            }

            $originalFilename = $request->file('foto')->getClientOriginalName();
            $extension = $request->file('foto')->getClientOriginalExtension();

            $newFilename = 'customer' . '/' . Str::random(30) . '.' . $extension;
            $request->file('foto')->move(public_path('customer/'), $newFilename);

            $user->foto = $newFilename;
            $user->save();

            return $this->sendMassage('Foto Profile terupdate', 200, true);
        }
    }

    public function tampilCustomer(Request $request)
    {

        $token = $request->bearerToken();
        $customer = Customer::where('token', $token)->first();

        if (!$token) {
            return $this->sendMassage('Customer tidak ditemukan', 400, false);
        }
        return $this->sendMassage($customer, 200, true);
    }

    public function tampilKurir(Request $request)
    {
        $token = $request->bearerToken();
        $kurir = Kurir::where('token', $token)->first();

        if (!$token) {
            return $this->sendMassage('Kurir tidak ditemukan', 400, false);
        }

        return $this->sendMassage($kurir, 200, true);
    }

    // List orderan pada setiap kantin
    public function listOrdersKantin(Request $request)
    {
        if ($request->has('id_kantin')) {

            // Ambil nilai ID kantin
            $id_kantin = $request->input('id_kantin');
            $dataList = Transaksi::select(
                'menu.foto as foto',
                'menu.id_menu as id_menu',
                'detail_transaksi.kode_tr as id_detail',
                'transaksi.created_at as tanggal',
                'transaksi.kode_tr',
                'detail_transaksi.catatan',
                'customer.nama as pembeli',
                'customer.no_telepon as no_telepon_pembeli',
                'transaksi.model_pembayaran',
                'transaksi.no_meja',
                'kantin.id_kantin as kantin',
                'menu.nama as pesanan',
                'menu.harga as harga_satuan',
                'detail_transaksi.QTY as jumlah',
                'menu.diskon as diskon',
                'transaksi.status_pengiriman as status',
                'detail_transaksi.status_konfirm as status_detail',
                'detail_transaksi.catatan'
            )
                ->leftJoin('customer', 'transaksi.id_customer', '=', 'customer.id_customer')
                ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
                ->leftJoin('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')
                ->where('kantin.id_kantin', $id_kantin)
                ->where('transaksi.status_pengiriman', 'proses')
                ->orderBy('detail_transaksi.created_at', 'DESC')
                ->get();

            // Konversi data menjadi format JSON dan kembalikan
            return $this->sendMassage($dataList, 200, true);
        } else {
            // Jika parameter ID kantin tidak diberikan, kirimkan pesan kesalahan
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    // Kantin
    public function updateprofile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'username' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user = User::find($request->input('id'));

        $user->username = $request->input('username');

        if ($request->hasFile('foto')) {
            // hapus foto terdahulu jika ada
            if ($user->foto) {
                Storage::delete('public/' . $user->foto);
            }

            // simpan foto baru
            $photo = $request->file('foto');
            $photoPath = $photo->store('profile', 'public');
            $user->foto = $photoPath;
        }

        $user->save();

        return response()->json(['message' => 'User updated successfully.', 'data' => $user]);
    }

    public function editStatus(Request $request)
    {
        $token = $request->bearerToken();

        $kantin = User::with(['Kantin' => function ($query) {
            $query->select('id_kantin', 'status');
        }])->where('token', $token)->first();

        $dataIdKantin = $kantin->kantin->id_kantin;

        if (isset($kantin)) {
            if ($kantin->kantin->status == true) {
                Kantin::where('id_kantin', $dataIdKantin)->update([
                    'status' => false
                ]);
                $selectStatus = Kantin::select('status')->where('id_kantin', $dataIdKantin)->first();
                return $this->sendMassage($selectStatus->status, 200, true);
            } elseif ($kantin->kantin->status == false) {
                Kantin::where('id_kantin', $dataIdKantin)->update([
                    'status' => true
                ]);
                $selectStatus = Kantin::select('status')->where('id_kantin', $dataIdKantin)->first();
                return $this->sendMassage($selectStatus->status, 200, true);
            }
        }
    }

    public function ubahprofile(Request $request, )
    {
        $user = User::findOrFail($request->id);

        return response()->json($user);
    }

    public function sendMassage($text, $kode, $status)
    {
        return response()->json([
            'data' => $text,
            'code' => $kode,
            'status' => $status
        ], $kode);
    }

    public function getPendapatanKurir(Request $request)
    {
        $token = $request->bearerToken();
        if (isset($token)) {
            $kurir = Kurir::where('token', $token)->first();
            if (isset($kurir)) {
                $pendapatanHariIni = $kurir->total_saldo;
                $pendapatanBulanIni = Transaksi::where('id_kurir', $kurir->id_kurir)
                    ->whereMonth('created_at', Carbon::now())
                    ->sum('total_biaya_kurir');
                return response()->json([
                    'data' => [
                        'month' => (int) $pendapatanBulanIni, 'today' => (int) $pendapatanHariIni
                    ],
                    'status' => true,
                    'message' => 'success fetch data'
                ], 200);
            }
            return $this->sendMassage("unauthenticated", 401, false);
        }
        return $this->sendMassage("unauthenticated", 401, false);
    }
}
