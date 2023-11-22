<?php

namespace App\Http\Controllers\API;


use App\Models\Menu;
use App\Models\Kurir;
use App\Models\Kantin;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\DetailTransaksi;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use App\Http\Middleware\ApiKeyMiddleware;

class ApiTransaction extends Controller
{
    public function __construct()
    {
        $this->middleware(ApiKeyMiddleware::class);
    }

    // List Riwayat Pesanan Pada Setiap Customer
    public function riwayatCustomer(Request $request)
    {
        //Mencari user dari token yang di dapatkan dari request
        $token = $request->bearerToken();
        $user = Customer::where('token', $token)->first();

        if (isset($user)) {
            $customer = $user->id_customer;
            $searchAll = $request->get('searchAll');
            $searchDate = $request->get('searchDate');

            // return $searchAll;
            if ($searchAll == '' && $searchDate == '') {
                $riwayatCutomer = Menu::select('transaksi.kode_tr', 'menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'), DB::raw('SUM(detail_transaksi.subtotal_bayar) as jumlah_subtotal'), 'transaksi.created_at')
                    ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                    ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                    ->join('customer', 'transaksi.id_customer', '=', 'customer.id_customer')
                    ->where('customer.id_customer', $customer)
                    ->groupBy('transaksi.kode_tr', 'menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', 'transaksi.created_at')
                    ->orderBy('transaksi.created_at', 'ASC')
                    // ->limit(10)
                    ->get();

                return $this->sendMassage($riwayatCutomer, 200, true);
            } elseif ($searchAll == '' && $searchDate != '') {
                $riwayatCutomer = Menu::select('transaksi.kode_tr', 'menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'), DB::raw('SUM(detail_transaksi.subtotal_bayar) as jumlah_subtotal'), 'transaksi.created_at')
                    ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                    ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                    ->join('customer', 'transaksi.id_customer', '=', 'customer.id_customer')
                    ->where('customer.id_customer', $customer)
                    ->whereDate('transaksi.created_at', $request->get('searchDate'))
                    ->groupBy('transaksi.kode_tr', 'menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', 'transaksi.created_at')
                    ->orderBy('transaksi.created_at', 'ASC')
                    // ->limit(10)
                    ->get();

                return $this->sendMassage($riwayatCutomer, 200, true);
            } elseif ($searchAll != '' && $searchDate == '') {
                $riwayatCutomer = Menu::select('transaksi.kode_tr', 'menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'), DB::raw('SUM(detail_transaksi.subtotal_bayar) as jumlah_subtotal'), 'transaksi.created_at')
                    ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                    ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                    ->join('customer', 'transaksi.id_customer', '=', 'customer.id_customer')
                    ->where('customer.id_customer', $customer)
                    ->where('menu.nama', 'LIKE', $request->get('searchAll') . '%')
                    ->groupBy('transaksi.kode_tr', 'menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', 'transaksi.created_at')
                    ->orderBy('transaksi.created_at', 'ASC')
                    // ->limit(10)
                    ->get();

                return $this->sendMassage($riwayatCutomer, 200, true);
            } elseif ($searchAll != '' && $searchDate != '') {
                $riwayatCutomer = Menu::select('transaksi.kode_tr', 'menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'), DB::raw('SUM(detail_transaksi.subtotal_bayar) as jumlah_subtotal'), 'transaksi.created_at')
                    ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                    ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                    ->join('customer', 'transaksi.id_customer', '=', 'customer.id_customer')
                    ->where('customer.id_customer', $customer)
                    ->where('menu.nama', 'LIKE', $request->get('searchAll') . '%')
                    ->whereDate('transaksi.created_at', $request->get('searchDate'))
                    ->groupBy('transaksi.kode_tr', 'menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', 'transaksi.created_at')
                    ->orderBy('transaksi.created_at', 'ASC')
                    // ->limit(10)
                    ->get();

                return $this->sendMassage($riwayatCutomer, 200, true);
            }
        }
        return $this->sendMassage('User Tidak Ditemukan', 200, true);
    }


    public function tampilTransaksi($id_customer)
    {
        $customer = Transaksi::where('id_customer', $id_customer)->first();

        if (!$customer) {
            return response()->json(['message' => 'Tranksaksi tidak ditemukan'], 404);
        }

        return response()->json($customer);
    }

    // public function detailPesanan($kode_tr)
    // {
    //     $detail = Transaksi::findOrFail($kode_tr);

    //     if ($detail) {
    //         $trans = DB::table('menu')->join('detail_transaksi', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')->select('menu.nama', 'detail_transaksi.QTY')->where('detail_transaksi.kode_tr', '=', $kode_tr)->get();
    //         return response()->json([$trans]);
    //     } else {
    //         return response()->json(['message', 'Transaksi tidak ditemukan'], 404);
    //     }
    // }

    public function tampilStatus($kode_tr, $status_pesanan, $status_konfirm)
    {
        $transaction = Transaksi::findOrFail($kode_tr);

        if ($transaction) {
            if ($status_pesanan == '1') {
                if ($status_konfirm == '1') {
                    $transaction->status_konfirm = '1';
                    $transaction->save();
                    return $this->sendMassage('Memasak', 200, true);
                } elseif ($status_konfirm == '2') {
                    $transaction->status_konfirm = '2';
                    $transaction->save();
                    return $this->sendMassage('Menunggu kurir', 200, true);
                } else {
                    return $this->sendMassage('Diproses', 200, true);
                }
            }

            if ($status_pesanan == '2') {
                if ($status_konfirm == '3') {
                    $transaction->status_konfirm = '3';
                    $transaction->save();
                    return $this->sendMassage('Proses', 200, true);
                }
            }

            if ($status_pesanan == '3') {
                if ($status_konfirm == '4') {
                    $transaction->status_konfirm = '4';
                    $transaction->save();
                    return $this->sendMassage('Menunggu', 200, true);
                } elseif ($status_konfirm == '5') {
                    $transaction->status_konfirm = '5';
                    $transaction->save();
                    return $this->sendMassage('Selesai', 200, true);
                }
            }
        }

    }

    public function statusKurir($kode_tr, $status_konfirm)
    {
        $kurir = Transaksi::findOrFail($kode_tr);

        if ($kurir) {
            if ($status_konfirm == '6') {
                $kurir->status_konfirm = '6';
                $kurir->status_pengiriman = 'Proses';
                $kurir->save();
                return $this->sendMassage($kurir->status_pengiriman, 200, true);
            } elseif ($status_konfirm == '7') {
                $kurir->status_konfirm = '7';
                $kurir->status_pengiriman = 'Kirim';
                $kurir->save();
                return $this->sendMassage($kurir->status_pengiriman, 200, true);
            }
        }
    }

    // List Pesanan Pada Setiap Customer
    public function transaksiCustomer(Request $request)
    {
        $dataDetailOrderan = $request->detail_orderan;

        $token = $request->bearerToken();
        $user = Customer::where('token', $token)->first();
        $customer = $user->id_customer;

        $dataOrderan = $request->orderan;
        $today = Carbon::now();

        $RandomNumber = rand(1000, 9999);
        $kodeTr = "TRDKN" . $RandomNumber;

        $Transaksi = new Transaksi();
        $Transaksi->kode_tr = $kodeTr;
        $Transaksi->status_konfirm = "1";
        $Transaksi->status_pesanan = "1";
        $Transaksi->tanggal = $today;
        $Transaksi->id_customer = $customer;
        // $Transaksi->id_kurir = $dataDetailOrderan['id_kurir'];
        $Transaksi->total_bayar = $dataDetailOrderan['total_bayar'];
        $Transaksi->total_harga = $dataDetailOrderan['total_harga'];
        $Transaksi->kembalian = $dataDetailOrderan['kembalian'];
        $Transaksi->status_pengiriman = "proses";
        // $Transaksi->bukti_pengiriman = $dataDetailOrderan['bukti_pengiriman'];
        $Transaksi->model_pembayaran = $dataDetailOrderan['model_pembayaran'];
        $Transaksi->save();

        foreach ($dataOrderan as $key => $value) {
            $detail = new DetailTransaksi();
            $detail->kode_tr = $kodeTr;
            $detail->kode_menu = $value['kode_menu'];
            $detail->QTY = $value['qty_barang'];
            $detail->subtotal_bayar = $value['total_harga_barang'];
            $detail->save();
        }

        return $this->sendMassage("Data berhasil di tambahkan", 200, true);
    }


    public function pesananDiproses(Request $request)
    {
        $token = $request->bearerToken();
        $user = Customer::where('token', $token)->first();

        if (!$user) {
            return $this->sendMassage('Token tidak valid', 401, false);
        }

        $transaksi = Transaksi::with('detail_transaksi.Menu')->where('id_customer', $user->id_customer)->where('status_pengiriman', 'proses')
            ->get();

        if (sizeof($transaksi) != 0) {

            $result = [];

            foreach ($transaksi as $key => $value) {
                $status_konfirm = $value['status_konfirm'];
                $status_pesanan = $value['status_pesanan'];
                $status_pengiriman = $value['status_pengiriman'];

                $status = null;

                if ($status_konfirm == '1' && $status_pesanan == '1' && $status_pengiriman == 'proses') {
                    $status = 'Menunggu Konfirmasi';
                } else if ($status_konfirm == '1' && $status_pesanan == '2' && $status_pengiriman == 'proses') {
                    $status = 'Memasak';
                } else if ($status_konfirm == '1' && $status_pesanan == '3' && $status_pengiriman == 'proses') {
                    $status = 'Menunggu kurir';
                }

                $temp = [
                    'status' => $status,
                    'transaksi' => $value,
                ];

                $result[] = $temp;

            }

            return $this->sendMassage($result, 200, true);
        } else {
            return $this->sendMassage('Tidak ada Data', 400, false);
        }
    }

    public function pesananDikirim(Request $request)
    {
        $token = $request->bearerToken();
        $user = Customer::where('token', $token)->first();


        if (!$user) {
            return $this->sendMassage('Token tidak valid', 401, false);
        }

        $transaksi = Transaksi::with('detail_transaksi.Menu')->where('id_customer', $user->id_customer)->where('status_pengiriman', 'kirim')
            ->get();

        // return $this->sendMassage($transaksi, 200, true);

        if (sizeof($transaksi) != 0) {

            $result = [];

            foreach ($transaksi as $key => $value) {
                $status_konfirm = $value['status_konfirm'];
                $status_pesanan = $value['status_pesanan'];
                $status_pengiriman = $value['status_pengiriman'];

                $status = null;

                if ($status_konfirm == '2' && $status_pesanan == '3' && $status_pengiriman == 'kirim') {
                    $status = 'proses';
                }

                $temp = [
                    'status' => $status,
                    'transaksi' => $value,
                ];

                $result[] = $temp;

            }

            return $this->sendMassage($result, 200, true);
        } else {
            return $this->sendMassage('Tidak ada Data', 400, false);
        }
    }

    public function pesananDiterima(Request $request)
    {
        $token = $request->bearerToken();
        $user = Customer::where('token', $token)->first();

        if (!$user) {
            return $this->sendMassage('Token tidak valid', 401, false);
        }

        $transaksi = Transaksi::with('detail_transaksi.Menu')->where('id_customer', $user->id_customer)->where('status_pengiriman', 'terima')
            ->get();

        if (sizeof($transaksi) != 0) {

            $result = [];

            foreach ($transaksi as $key => $value) {
                $status_konfirm = $value['status_konfirm'];
                $status_pesanan = $value['status_pesanan'];
                $status_pengiriman = $value['status_pengiriman'];

                $status = null;

                if ($status_konfirm == '2' && $status_pesanan == '3' && $status_pengiriman == 'terima') {
                    $status = 'Menunggu';
                } else if ($status_konfirm == '3' && $status_pesanan == '3' && $status_pengiriman == 'terima') {
                    $status = 'Selesai';
                }

                $temp = [
                    'status' => $status,
                    'transaksi' => $value,
                ];

                $result[] = $temp;

            }

            return $this->sendMassage($result, 200, true);
        } else {
            return $this->sendMassage('Tidak ada Data', 400, false);
        }
    }

    public function pesananUntukDikirim(Request $request)
    {
        $token = $request->bearerToken();
        $user = Kurir::where('token', $token)->first();

        if (!$user) {
            return $this->sendMassage('Token tidak valid', 401, false);
        }

        $transaksi = Transaksi::select('transaksi.kode_tr', 'transaksi.created_at', DB::raw('SUM(detail_transaksi.QTY) as QTY'), 'transaksi.total_harga')
            ->join('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->where('transaksi.id_kurir', '=', $user->id_kurir)
            ->where('transaksi.status_pengiriman', '=', 'proses')
            ->where('transaksi.status_konfirm', '=', '1')
            ->where('transaksi.status_pesanan', '=', '3')
            ->groupBy('transaksi.kode_tr')
            ->get();

        if (isset($transaksi)) {
            return $this->sendMassage($transaksi, 200, true);
        } else {
            return $this->sendMassage('Tidak ada Data', 400, false);
        }
    }

    public function pesananKonfirmasi(Request $request)
    {
        $token = $request->bearerToken();
        $user = Kurir::where('token', $token)->first();

        if (!$user) {
            return $this->sendMassage('Token tidak valid', 401, false);
        }

        $transaksi = Transaksi::select('transaksi.kode_tr', 'transaksi.created_at', DB::raw('SUM(detail_transaksi.QTY) as QTY'), 'transaksi.total_harga', 'transaksi.status_pengiriman', 'transaksi.status_konfirm', 'transaksi.status_pesanan')
            ->join('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->where('transaksi.id_kurir', '=', $user->id_kurir)
            ->groupBy('transaksi.kode_tr')
            ->get();

        if (sizeof($transaksi) != 0) {

            $result = [];

            foreach ($transaksi as $key => $value) {
                $status_konfirm = $value['status_konfirm'];
                $status_pesanan = $value['status_pesanan'];
                $status_pengiriman = $value['status_pengiriman'];

                $status = null;

                if ($status_konfirm == '2' && $status_pesanan == '3' && $status_pengiriman == 'kirim') {
                    $status = 'Menunggu';
                } else if ($status_konfirm == '2' && $status_pesanan == '3' && $status_pengiriman == 'terima') {
                    $status = 'Menunggu 2';
                } else if ($status_konfirm == '3' && $status_pesanan == '3' && $status_pengiriman == 'terima') {
                    $status = 'Selesai';
                }

                $temp = [
                    'transaksi' => $value,
                    'status' => $status
                ];

                $result[] = $temp;

            }

            return $this->sendMassage($result, 200, true);
        } else {
            return $this->sendMassage('Tidak ada Data', 400, false);
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
