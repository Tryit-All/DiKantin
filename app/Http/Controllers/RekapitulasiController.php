<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:rekapitulasi-list|cek-Rekapitulasi|cetak-Rekapitulasi', ['only' => ['index', 'cekRekapitulasi', 'cetak']]);
        $this->middleware('permission:rekapitulasi-list', ['only' => ['index']]);
        $this->middleware('permission:cek-Rekapitulasi', ['only' => ['cekRekapitulasi']]);
        $this->middleware('permission:cetak-Rekapitulasi', ['only' => ['cetak']]);
    }

    public function index()
    {
        return view('dashboard.rekapitulasi.index');
    }

    public function cekRekapitulasi($tglMulai, $tglSelesai)
    {
        $data = DetailTransaksi::with([
            'Menu.Kantin:id,nama_kantin',
        ])
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('transaksi.status_pengiriman', 'terima')
            ->selectRaw(
                "transaksi.kode_tr as kode, kantin.id_kantin as id_kantin,
        kantin.nama as nama_kantin,
        SUM(menu.harga) as harga_satuan,
        SUM(detail_transaksi.QTY) as jumlah,
        SUM(menu.diskon) as diskon,
        SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga * detail_transaksi.QTY,
            (menu.harga * detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga * detail_transaksi.QTY))
        )) as total, transaksi.model_pembayaran as metode"
            )
            ->groupBy('kantin.id_kantin', 'kantin.nama', 'transaksi.model_pembayaran', 'transaksi.kode_tr')
            ->orderBy('kantin.id_kantin', 'asc')
            ->get();

        $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('transaksi.status_pengiriman', 'terima')
            ->selectRaw('SUM(detail_transaksi.QTY) as jumlah')
            ->orderBy('transaksi.kode_tr', 'asc')
            ->value('jumlah');

        $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')
            ->value('total');

        // return $data;

        return view(
            'dashboard.rekapitulasi.cekRekapitulasi',
            [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
            ]
        );
    }

    public function cetak($tglMulai, $tglSelesai)
    {
        $data = DetailTransaksi::with([
            'Menu.Kantin:id,nama_kantin',
        ])
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('transaksi.status_pengiriman', 'terima')
            ->selectRaw(
                "transaksi.kode_tr as kode, kantin.id_kantin as id_kantin,
        kantin.nama as nama_kantin,
        SUM(menu.harga) as harga_satuan,
        SUM(detail_transaksi.QTY) as jumlah,
        SUM(menu.diskon) as diskon,
        SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga * detail_transaksi.QTY,
            (menu.harga * detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga * detail_transaksi.QTY))
        )) as total, transaksi.model_pembayaran as metode"
            )
            ->groupBy('kantin.id_kantin', 'kantin.nama', 'transaksi.model_pembayaran', 'transaksi.kode_tr')
            ->orderBy('kantin.id_kantin', 'asc')
            ->get();

        $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('transaksi.status_pengiriman', 'terima')
            ->selectRaw('SUM(detail_transaksi.QTY) as jumlah')
            ->orderBy('transaksi.kode_tr', 'asc')
            ->value('jumlah');

        $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')
            ->value('total');

        return view(
            'dashboard.rekapitulasi.cetak',
            [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
            ]
        );
    }
}
