<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Models\Customer;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

    public function editCustomer(Request $request)
    {
        // $customer = Customer::where('id_customer', $id_customer)->first();
        $token = $request->bearerToken();

        $user = Customer::where('token', $token)->first();

        if ($user) {
            $user->nama = $request->input('nama');
            $user->email = $request->input('email');
            $user->no_telepon = $request->input('no_telepon');
            $user->alamat = $request->input('alamat');

            $user->save();

            return $this->sendMassage('Data terupdate', 200, true);
        } else {
            return $this->sendMassage('Pelanggan tidak ditemukan', 400, false);
        }
    }



    public function transaksiCustomer(Request $request)
    {
        $dataDetailOrderan = $request->detail_orderan;
        $dataOrderan = $request->orderan;
        $today = Carbon::now();

        $Transaksi = new Transaksi();
        $Transaksi->kode_tr = $dataDetailOrderan['kode_tr'];
        $Transaksi->status_konfirm = $dataDetailOrderan['status_konfirm'];
        $Transaksi->status_pesanan = $dataDetailOrderan['status_pesanan'];
        $Transaksi->tanggal = $today;
        $Transaksi->id_customer = $dataDetailOrderan['id_customer'];
        $Transaksi->id_kurir = $dataDetailOrderan['id_kurir'];
        $Transaksi->total_bayar = $dataDetailOrderan['total_bayar'];
        $Transaksi->total_harga = $dataDetailOrderan['total_harga'];
        $Transaksi->kembalian = $dataDetailOrderan['kembalian'];
        $Transaksi->status_pengiriman = $dataDetailOrderan['status_pengiriman'];
        $Transaksi->bukti_pengiriman = $dataDetailOrderan['bukti_pengiriman'];
        $Transaksi->model_pembayaran = $dataDetailOrderan['model_pembayaran'];
        $Transaksi->save();

        foreach ($dataOrderan as $key => $value) {
            $detail = new DetailTransaksi();
            $detail->kode_tr = $dataDetailOrderan['kode_tr'];
            $detail->kode_menu = $value['kode_menu'];
            $detail->QTY = $value['qty_barang'];
            $detail->subtotal_bayar = $value['total_harga_barang'];
            $detail->save();
        }

        return $this->sendMassage("Data berhasil di tambahkan", 200, true);
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
