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
