<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class LaporanController extends Controller
{

    public function index()
    {
        return view(
            'dashboard.laporan.index',
        );
    }

    public function cekLaporan($tglMulai, $tglSelesai, $idKantin, $status)
    {
        $data = Transaksi::with([
            'detail_transaksi.menu:id_menu,nama,harga,foto,status_stok,kategori,diskon',
            'detail_transaksi' => function ($query) use ($status) {
                $query->where('status_konfirm', $status);
            },
            'customer:id_customer,nama,no_telepon,alamat,email',
            'kurir:id_kurir,nama',
            'kantin:id_kantin,nama,status'
        ])
            ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
            ->whereHas('detail_transaksi.menu.kantin', function ($query) use ($idKantin) {
                $query->where('id_kantin', $idKantin);
            })
            ->orderBy('kode_tr', 'desc')
            ->get();

        $jumlah = Transaksi::whereBetween('tanggal', [$tglMulai, $tglSelesai])
            ->whereHas('detail_transaksi', function ($query) use ($idKantin, $status) {
                $query->where('status_konfirm', $status);
            })
            ->sum('detail_transaksi.QTY');

        $sumTotal = DetailTransaksi::whereHas('menu.kantin', function ($query) use ($idKantin) {
            $query->where('id_kantin', $idKantin);
        })
            ->where('status_konfirm', $status)
            ->whereBetween('created_at', [$tglMulai, $tglSelesai])
            ->sum(DB::raw("IFNULL(diskon, 0) = 0, harga*QTY, (harga*QTY) - (diskon/100*(harga*QTY))"));

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
        $data = Transaksi::with([
            'detail_transaksi.Menu:id_menu,nama,harga,foto,status_stok,kategori,diskon',
            'detail_transaksi' => function ($query) use ($status) {
                $query->where('status_konfirm', $status);
            },
            'customer:id_customer,nama,no_telepon,alamat,email',
            'user:id_user,name',
            'kantin:id_kantin,nama_kantin',
        ])
            ->whereBetween('tanggal', [$tglMulai, $tglSelesai])
            ->whereHas('detail_transaksi.Menu.Kantin', function ($query) use ($idKantin) {
                $query->where('id_kantin', $idKantin);
            })
            ->orderBy('kode_tr', 'desc')
            ->get();

        $jumlah = Transaksi::whereBetween('tanggal', [$tglMulai, $tglSelesai])
            ->whereHas('detail_transaksi', function ($query) use ($idKantin, $status) {
                $query->where('status_konfirm', $status);
            })
            ->sum('detail_transaksi.QTY');

        $sumTotal = DetailTransaksi::whereHas('Menu.Kantin', function ($query) use ($idKantin) {
            $query->where('id_kantin', $idKantin);
        })
            ->where('status_konfirm', $status)
            ->whereBetween('created_at', [$tglMulai, $tglSelesai])
            ->sum(DB::raw("IFNULL(diskon, 0) = 0, harga*QTY, (harga*QTY) - (diskon/100*(harga*QTY))"));

        return view('dashboard.laporan.cetak', [
            'data' => $data,
            'sumTotal' => $sumTotal,
            'jumlah' => $jumlah,
            'tglMulai' => $tglMulai,
            'tglSelesai' => $tglSelesai,
        ]);
    }
}
