<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:Transaksi-list|Transaksi-detail|Transaksi-hapus', ['only' => ['index', 'detail', 'destroy']]);
        // $this->middleware('permission:Transaksi-list', ['only' => ['index']]);
        // $this->middleware('permission:Transaksi-detail', ['only' => ['detail']]);
        // $this->middleware('permission:Transaksi-hapus', ['only' => ['destroy']]);
    }
    public function index()
    {
        $transaksi = Transaksi::select('kode_tr', 'created_at', 'no_meja', 'total_bayar', 'total_harga', 'kembalian')
            ->groupBy('kode_tr')
            ->orderBy('kode_tr', 'desc')
            ->get();

        // return $transaksi;

        return view('dashboard.transaksi.index', [
            'data' => $transaksi
        ]);
    }
    public function order_online()
    {
        
        $transaksi = Transaksi::with(['detail_transaksi','Customer','Kurir'])->where('status_pengiriman','proses')
        ->where('no_meja','=',null)->get();
        return view('dashboard.transaksi.pesanan_online',compact('transaksi'));

        // return $transaksi;

      
    }

    public function detail($id)
    {
        $penjualan = Transaksi::with(['detail_transaksi', 'detail_transaksi','Customer'])
            ->where('kode_tr', $id)
            ->first();
        // return $penjualan;
        return view('dashboard.transaksi.cetak', [
            'penjualan' => $penjualan
        ]);
    }
    public function detail_tr($id)
    {
        $penjualan = DetailTransaksi::with(['Menu'])
            ->where('kode_tr', $id)->get();
          
        // return $penjualan;
        return view('dashboard.transaksi.detail_tranakasi', [
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
