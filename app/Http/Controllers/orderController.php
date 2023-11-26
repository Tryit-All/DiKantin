<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:order-list', ['only' => ['get_all_order']]);
    }

    public function get_all_order()
    {
        $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kurir')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->where('transaksi.status_pengiriman', 'proses')
            ->orderBy('transaksi.kode_tr', 'desc')
            ->select(
                'menu.foto as foto',
                'detail_transaksi.kode_tr as id_detail',
                'transaksi.tanggal as tanggal',
                'transaksi.kode_tr as nomer_penjualan',
                'customer.nama as pembeli',
                'customer.no_telepon as no_telepon_pembeli',
                'user.username as kasir',
                'transaksi.model_pembayaran',
                'transaksi.no_meja',
                'kantin.nama as kantin',
                'menu.nama as pesanan',
                'menu.harga as harga_satuan',
                'detail_transaksi.QTY as jumlah',
                'menu.diskon as diskon',
                'transaksi.status_pesanan as status'
            )
            ->get();
        // dd($data);
        // $data = Detail_penjualan::where('status', 'proses')->get();
        return view('dashboard.order.waiting', compact('data'));
    }

    public function delete_order($id)
    {
        DetailTransaksi::findOrFail($id)->delete();
        return redirect()->back();
    }
}
