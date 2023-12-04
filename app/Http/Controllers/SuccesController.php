<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SuccesController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:successorder-list', ['only' => ['index']]);
    }

    public function get_order_solved()
    {
        $data = Transaksi::select(
            'transaksi.kode_tr AS Kode_Tr',
            'transaksi.created_at AS Tanggal_Order',
            'transaksi.updated_at AS Tanggal_Selesai',
            'customer.nama AS Customer',
            'kurir.nama AS Kurir',
            DB::raw('IF(transaksi.no_meja IS NULL OR transaksi.no_meja = 0, "Customer Online", transaksi.no_meja) AS Detail'),
            'transaksi.model_pembayaran AS Pembayaran',
            'transaksi.bukti_pengiriman AS Bukti',
            'transaksi.status_konfirm AS SK',
            'transaksi.status_pesanan AS SP',
            'transaksi.total_harga AS Total',
            'transaksi.status_pengiriman AS Status'
        )
            ->leftJoin('customer', 'transaksi.id_customer', '=', 'customer.id_customer')
            ->join('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('kurir', 'transaksi.id_kurir', '=', 'kurir.id_kurir')
            ->where('transaksi.status_pengiriman', 'terima')
            ->groupBy('transaksi.kode_tr')
            ->orderBy('transaksi.kode_tr', 'desc')
            ->get();
        // dd($data);
        // $data = Detail_penjualan::where('status', 'proses')->get();
        return view('dashboard.order.success', compact('data'));
    }

    public function validate_success($kode_tr)
    {
        Transaksi::where('kode_tr', $kode_tr)->update([
            'status_konfirm' => '3',
            'bukti_pengiriman' => 'Done',
        ]);
        return redirect()->back();
    }

    public function trouble_transaction($kode_tr)
    {
        Transaksi::where('kode_tr', $kode_tr)->update([
            'status_konfirm' => '2',
            'status_pesanan' => '3',
            'status_pengiriman' => 'kirim',
            'bukti_pengiriman' => null,
        ]);
        return redirect()->back();
    }

}
