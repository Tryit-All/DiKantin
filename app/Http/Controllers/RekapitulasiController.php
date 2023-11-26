<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class RekapitulasiController extends Controller
{
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
            ->whereBetween('tanggal_penjualan', [$tglMulai, $tglSelesai])
            ->where('status', 'selesai')
            ->selectRaw(
                "kantin.id_kantin as id,
                kantin.nama as kantin,
                SUM(menu.harga) as harga_satuan,
                SUM(detail_penjualan.QTY) as jumlah,
                SUM(menu.diskon) as diskon,
                SUM(if(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    menu.harga*QTY,
                    (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
                )) as total"
            )
            ->groupBy('kantin.id_kantin')
            ->orderBy('kantin.id_kantin', 'asc')
            ->get();

        $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('detail_transaksi.status_konfirm', 'selesai')
            ->selectRaw('SUM(detail_transaksi.QTY) as jumlah')
            ->orderBy('transaksi.kode_tr', 'asc')
            ->value('jumlah');

        $sumTotal = DetailTransaksi::where('status_konfirm', 'selesai')
            ->whereBetween('created_at', [$tglMulai, $tglSelesai])
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')
            ->value('total');

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
            ->whereBetween('tanggal_penjualan', [$tglMulai, $tglSelesai])
            ->where('status', 'selesai')
            ->selectRaw(
                "kantins.id as id,
                kantins.nama_kantin as kantin,
                SUM(detail_penjualans.harga) as harga_satuan,
                SUM(detail_penjualans.jumlah) as jumlah,
                SUM(detail_penjualans.diskon) as diskon,
                SUM(if(
                    diskon IS NULL OR diskon = 0,
                    harga*jumlah,
                    (harga*jumlah) - (diskon/100*(harga*jumlah))
                )) as total"
            )
            ->groupBy('kantins.id')
            ->orderBy('kantins.id', 'asc')
            ->get();

        $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menus', 'menus.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantins', 'kantins.id_kantin', '=', 'menus.id_kantin')
            ->whereBetween('transaksi.tanggal', [$tglMulai, $tglSelesai])
            ->where('detail_transaksi.status_konfirm', 'selesai')
            ->selectRaw('SUM(detail_transaksi.QTY) as jumlah')
            ->orderBy('transaksi.id', 'asc')
            ->value('jumlah');

        $sumTotal = DetailTransaksi::where('status', 'selesai')
            ->whereBetween('tanggal_penjualan', [$tglMulai, $tglSelesai])
            ->selectRaw('SUM(if(
                diskon IS NULL OR diskon = 0,
                harga*jumlah,
                (harga*jumlah) - (diskon/100*(harga*jumlah))
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
