<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RekapitulasiExport;
use App\Http\Middleware\AdminDLLMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DwpMiddleware;
use App\Http\Middleware\KasirMiddleware;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;

use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

class LaporanKurirController extends Controller
{

    function __construct()
    {
        $this->middleware([AdminDLLMiddleware::class]);
    }
    public function index()
    {
        $ongkirByCourier = Transaksi::selectRaw('transaksi.id_kurir,transaksi.kode_tr,SUM(transaksi.total_biaya_kurir) as total_ongkir, kurir.nama as nama_kurir')
            ->join('kurir', 'transaksi.id_kurir', '=', 'kurir.id_kurir') // Join tabel transaksi dengan tabel kurir berdasarkan id_kurir
            ->where('transaksi.status_pengiriman', 'terima')
            ->whereNotNull('transaksi.id_kurir')
            ->whereDate('transaksi.created_at', now()->toDateString())
            ->groupBy('transaksi.id_kurir', 'transaksi.kode_tr')->get(); // Menambahkan kolom kurirs.nama ke dalam grup

        $total_keseluruhan_ongkir = Transaksi::whereDate('created_at', now()->toDateString())->where('status_pengiriman', 'terima')->whereNotNull('id_kurir')->sum('total_biaya_kurir');
        return view(
            'dashboard.kurir.Kurir',
            [
                'ongkirByCourier' => $ongkirByCourier,
                'total_keseluruhan_ongkir' => $total_keseluruhan_ongkir,

            ]
        );
    }
    public function cekOnkirKurir($tglMulai,$tglSelesai)
    {
        $tglSelesai = $tglSelesai . ' 23:59:00';
        $tglMulai = $tglMulai . ' 00:00:00';
        $ongkirByCourier = Transaksi::selectRaw('transaksi.id_kurir,transaksi.kode_tr,SUM(transaksi.total_biaya_kurir) as total_ongkir, kurir.nama as nama_kurir')
            ->join('kurir', 'transaksi.id_kurir', '=', 'kurir.id_kurir') // Join tabel transaksi dengan tabel kurir berdasarkan id_kurir
            ->where('transaksi.status_pengiriman', 'terima')
            ->whereNotNull('transaksi.id_kurir')
            ->whereBetween('transaksi.created_at',[$tglMulai,$tglSelesai])
            ->groupBy('transaksi.id_kurir', 'transaksi.kode_tr')->get();


        $total_keseluruhan_ongkir = Transaksi::whereBetween('created_at', [$tglMulai, $tglSelesai])->where('status_pengiriman', 'terima')->whereNotNull('id_kurir')->sum('total_biaya_kurir');

        $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
        $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');

        return view(
            'dashboard.kurir.cekKurir',
            [
                'ongkirByCourier' => $ongkirByCourier,
                'total_keseluruhan_ongkir' => $total_keseluruhan_ongkir,
              
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,


            ]
        );
    }
}
