<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kurir')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->selectRaw(
                'transaksi.kode_tr as id,
                transaksi.tanggal as tanggal,
                transaksi.total_harga as total,
                transaksi.total_bayar as bayar,
                transaksi.kembalian as kembalian,
                transaksi.kode_tr as nomer_penjualan,
                customer.nama as pembeli,
                user.username as kasir,
                transaksi.model_pembayaran,
                transaksi.no_meja,
                kantin.nama as kantin,
                menu.harga as harga_satuan,
                menu.diskon as diskon,
                transaksi.status_pengiriman as status'
            )
            ->groupBy('transaksi.kode_tr')
            ->orderBy('transaksi.kode_tr', 'desc')
            ->get();

        return view('dashboard.transaksi.index', [
            'data' => $data
        ]);
    }

    public function detail($id)
    {
        $penjualan = Transaksi::with(['detail_transaksi', 'detail_transaksi.Menu'])
            ->where('kode_tr', $id)
            ->first();
        return view('dashboard.transaksi.cetak', [
            'penjualan' => $penjualan
        ]);
    }


    public function destroy($id)
    {
        $data = Transaksi::findOrFail($id);
        $data->delete();
        return redirect()->back();
    }
}
