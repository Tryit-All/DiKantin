<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:laporan-list|laporan-cetak', ['only' => ['index', 'cetak']]);
        $this->middleware('permission:laporan-list', ['only' => ['index']]);
        $this->middleware('permission:laporan-cetak', ['only' => ['cetak']]);
    }

    public function index()
    {
        return view(
            'dashboard.laporan.index',
        );
    }

    public function cekLaporan($tglMulai, $tglSelesai, $idKantin, $status)
    {
        $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('kantin.id_kantin', $idKantin)
            ->where('transaksi.status_pengiriman', $status)
            ->select(
                'transaksi.created_at as tanggal',
                'transaksi.kode_tr',
                'customer.nama as pembeli',
                'user.username as kasir',
                'kantin.nama as kantin',
                'menu.nama as pesanan',
                'menu.harga as harga_satuan',
                'detail_transaksi.QTY as jumlah',
                'menu.diskon as diskon',
                'status_pengiriman'
            )
            ->orderBy('transaksi.kode_tr', 'desc')
            ->get();

        $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('kantin.id_kantin', $idKantin)
            ->where('transaksi.status_pengiriman', $status)
            ->select(
                'detail_transaksi.QTY as jumlah',
            )
            ->orderBy('transaksi.kode_tr', 'desc')
            ->value('jumlah');

        $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('kantin.id_kantin', $idKantin)
            ->where('transaksi.status_pengiriman', $status)
            ->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'")
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')->value('total');


        return view('dashboard.laporan.cekLaporan', [
            'data' => $data,
            'sumTotal' => $sumTotal,
            'jumlah' => $jumlah,
            'tglMulai' => $tglMulai,
            'tglSelesai' => $tglSelesai,
            'idKantin' => $idKantin,
            'status' => $status
        ]);
    }

    public function cetak($tglMulai, $tglSelesai, $idKantin, $status)
    {
        $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('kantin.id_kantin', $idKantin)
            ->where('transaksi.status_pengiriman', $status)
            ->select(
                'transaksi.created_at as tanggal',
                'transaksi.kode_tr',
                'customer.nama as pembeli',
                'user.username as kasir',
                'kantin.nama as kantin',
                'menu.nama as pesanan',
                'menu.harga as harga_satuan',
                'detail_transaksi.QTY as jumlah',
                'menu.diskon as diskon',
                'status_pengiriman'
            )
            ->orderBy('transaksi.kode_tr', 'desc')
            ->get();

        $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('kantin.id_kantin', $idKantin)
            ->where('transaksi.status_pengiriman', $status)
            ->select(
                'detail_transaksi.QTY as jumlah',
            )
            ->orderBy('transaksi.kode_tr', 'desc')
            ->value('jumlah');

        $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('kantin.id_kantin', $idKantin)
            ->where('transaksi.status_pengiriman', $status)
            ->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'")
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')->value('total');

        return view('dashboard.laporan.cetak', [
            'data' => $data,
            'sumTotal' => $sumTotal,
            'jumlah' => $jumlah,
            'tglMulai' => $tglMulai,
            'tglSelesai' => $tglSelesai,
        ]);
    }
}
