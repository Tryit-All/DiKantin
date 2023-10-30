<?php

namespace App\Http\Controllers\API;

use App\Models\Menu;
use App\Models\Customer;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use App\Http\Middleware\ApiKeyMiddleware;

class ApiTransaction extends Controller
{
    public function __construct()
    {
        $this->middleware(ApiKeyMiddleware::class);
    }

    public function riwayatCustomer(Request $request)
    {
        $token = $request->bearerToken();

        $user = Customer::where('token', $token)->first();

        if (isset($user)) {
            $customer = $user->id_customer;
            $riwayatCutomer = Menu::select('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'), DB::raw('SUM(detail_transaksi.subtotal_bayar) as jumlah_subtotal'), 'transaksi.created_at')
                ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                ->join('customer', 'transaksi.id_customer', '=', 'customer.id_customer')
                ->where('customer.id_customer', $customer)
                ->where('menu.nama', 'LIKE', $request->segment(4) . '%')
                ->groupBy('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', 'transaksi.created_at')
                ->orderBy('penjualan_hari_ini', 'desc')
                ->limit(10)
                ->get();

            return $this->sendMassage($riwayatCutomer, 200, true);
        }
        return $this->sendMassage('User Tidak Ditemukan', 200, true);
    }


    public function tampilTransaksi(Request $request, $id_customer){

        $transaction = Transaksi::findOrFail($id_customer);

        return response()->json($transaction);
    }

    public function tampilStatus($kode_tr, $status_pesanan, $status_konfirm)
        {
            $transaction = Transaksi::findOrFail($kode_tr);

            if($transaction)
            {
                if($status_pesanan == '1')
                {
                    if($status_konfirm == '1')
                    {
                        $transaction->status_konfirm = '1';
                        $transaction->save();
                        return response()->json('Memasak');
                    }elseif($status_konfirm == '2')
                    {
                        $transaction->status_konfirm = '2';
                        $transaction->save();
                        return response()->json('Menunggu kurir');
                    }
                }

                if($status_pesanan == '2'){
                    if($status_konfirm == '3'){
                        $transaction->status_konfirm = '3';
                        $transaction->save();
                        return response()->json('Proses');
                    }
                }

                if($status_pesanan == '3')
                {
                    if($status_konfirm == '4')
                    {
                        $transaction->status_konfirm = '4';
                        $transaction->save();
                        return response()->json('Menunggu');
                    }elseif($status_konfirm == '5')
                    {
                        $transaction->status_konfirm = '5';
                        $transaction->save();
                        return response()->json('Selesai');
                    }
                }
            }

        }

        public function editCustomer ()
        {
            //
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
