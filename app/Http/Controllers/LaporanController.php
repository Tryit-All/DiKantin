<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
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
        $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->select(
                'transaksi.created_at as tanggal',
                'transaksi.kode_tr',
                'customer.nama as pembeli',
                'user.username as kasir',
                'kantin.nama as kantin',
                'menu.nama as pesanan',
                'menu.harga as harga_satuan',
                'menu.harga_pokok as harga_pokok',
                'detail_transaksi.QTY as jumlah',
                'menu.diskon as diskon',
                'status_pengiriman'
            )
            ->orderBy('transaksi.created_at', 'desc')->whereDate('transaksi.created_at', now()->toDateString())
            ->get();
        $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->select('detail_transaksi.QTY as jumlah')
            ->orderBy('transaksi.kode_tr', 'desc')

            ->whereDate('transaksi.created_at', now()->toDateString());


        $jumlah = $jumlah->sum('detail_transaksi.QTY');
        $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString());
        $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString());


        $sumTotal = $sumTotal->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')->value('total');

        $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok*QTY,
                (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
            )) as total_pokok')->value('total_pokok');
        $pendapatan = $sumTotal - $sumTotalPokok;

        return view(
            'dashboard.laporan.index',
            compact(['data', 'jumlah', 'sumTotal', 'sumTotalPokok', 'pendapatan'])
        );
    }
    public function cetakSemua()
    {
        $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->select(
                'transaksi.created_at as tanggal',
                'transaksi.kode_tr',
                'customer.nama as pembeli',
                'user.username as kasir',
                'kantin.nama as kantin',
                'menu.nama as pesanan',
                'menu.harga as harga_satuan',
                'menu.harga_pokok as harga_pokok',
                'detail_transaksi.QTY as jumlah',
                'menu.diskon as diskon',
                'status_pengiriman'
            )
            ->orderBy('transaksi.created_at', 'desc')->whereDate('transaksi.created_at', now()->toDateString())
            ->get();


        $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->select('detail_transaksi.QTY as jumlah')->whereDate('transaksi.created_at', now()->toDateString())
            ->orderBy('transaksi.kode_tr', 'desc');



        $jumlah = $jumlah->sum('detail_transaksi.QTY');
        $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString());

        $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString());
        $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString());


        $sumTotal = $sumTotal->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')->value('total');

        $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok*QTY,
                (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
            )) as total_pokok')->value('total_pokok');
        $pendapatan = $sumTotal - $sumTotalPokok;


        return view('dashboard.laporan.cetaksemua', [
            'data' => $data,
            'sumTotal' => $sumTotal,
            'sumTotalPokok' => $sumTotalPokok,
            'pendapatan' => $pendapatan,

            'jumlah' => $jumlah,


        ]);
    }

    public function cekLaporan($tglMulai, $tglSelesai, $idKantin, $status)
    {
        $tglSelesai = $tglSelesai . ' 23:59:00';
        $tglMulai = $tglMulai . ' 00:00:00';
        if (($idKantin != 'p') && ($status != 'p')) {
            # code

            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
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
                    'menu.harga_pokok as harga_pokok',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pengiriman'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

            $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $idKantin)
                ->where('transaksi.status_pengiriman', $status)
                ->select('detail_transaksi.QTY as jumlah')
                ->orderBy('transaksi.kode_tr', 'desc');

            if ($tglMulai == $tglSelesai) {
                $jumlah->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $jumlah = $jumlah->sum('detail_transaksi.QTY');


            $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('kantin.id_kantin', $idKantin)
                ->where('transaksi.status_pengiriman', $status);

            if ($tglMulai == $tglSelesai) {
                $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }
            $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('kantin.id_kantin', $idKantin)
                ->where('transaksi.status_pengiriman', $status);

            if ($tglMulai == $tglSelesai) {
                $sumTotalPokok->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotalPokok->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotal = $sumTotal->selectRaw('SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga*QTY,
            (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
        )) as total')->value('total');

            $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga_pokok*QTY,
            (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
        )) as total_pokok')->value('total_pokok');
            $pendapatan = $sumTotal - $sumTotalPokok;
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cekLaporan', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
                'idKantin' => $idKantin,
                'status' => $status
            ]);
        } elseif (($idKantin == "p") && ($status == "p")) {
            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->select(
                    'transaksi.created_at as tanggal',
                    'transaksi.kode_tr',
                    'customer.nama as pembeli',
                    'user.username as kasir',
                    'kantin.nama as kantin',
                    'menu.nama as pesanan',
                    'menu.harga as harga_satuan',
                    'menu.harga_pokok as harga_pokok',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pengiriman'
                )
                ->orderBy('transaksi.created_at', 'desc');


            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

            $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')

                ->select('detail_transaksi.QTY as jumlah')
                ->orderBy('transaksi.kode_tr', 'desc');

            if ($tglMulai == $tglSelesai) {
                $jumlah->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $jumlah = $jumlah->sum('detail_transaksi.QTY');

            $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr');

            if ($tglMulai == $tglSelesai) {
                $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr');

            if ($tglMulai == $tglSelesai) {
                $sumTotalPokok->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotalPokok->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotal = $sumTotal->selectRaw('SUM(if(
        menu.diskon IS NULL OR menu.diskon = 0,
        menu.harga*QTY,
        (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
    )) as total')->value('total');
            $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
        menu.diskon IS NULL OR menu.diskon = 0,
        menu.harga_pokok*QTY,
        (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
    )) as total_pokok')->value('total_pokok');
            $pendapatan = $sumTotal - $sumTotalPokok;
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cekLaporan', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
                'idKantin' => $idKantin,
                'status' => $status
            ]);
        } elseif (($idKantin == 'p') && ($status !== 'p')) {

            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')

                ->where('transaksi.status_pengiriman', $status)
                ->select(
                    'transaksi.created_at as tanggal',
                    'transaksi.kode_tr',
                    'customer.nama as pembeli',
                    'user.username as kasir',
                    'kantin.nama as kantin',
                    'menu.harga_pokok as harga_pokok',
                    'menu.nama as pesanan',
                    'menu.harga as harga_satuan',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pengiriman'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

            $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')

                ->where('transaksi.status_pengiriman', $status)
                ->select('detail_transaksi.QTY as jumlah')
                ->orderBy('transaksi.kode_tr', 'desc');

            if ($tglMulai == $tglSelesai) {
                $jumlah->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $jumlah = $jumlah->sum('detail_transaksi.QTY');

            $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')

                ->where('transaksi.status_pengiriman', $status);

            if ($tglMulai == $tglSelesai) {
                $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }
            $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('transaksi.status_pengiriman', $status);

            if ($tglMulai == $tglSelesai) {
                $sumTotalPokok->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotalPokok->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotal = $sumTotal->selectRaw('SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga*QTY,
            (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
        )) as total')->value('total');
            $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga_pokok*QTY,
            (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
        )) as total_pokok')->value('total_pokok');
            $pendapatan = $sumTotal - $sumTotalPokok;
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cekLaporan', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
                'idKantin' => $idKantin,
                'status' => $status
            ]);
        } elseif (($idKantin !== 'p') && ($status == 'p')) {
            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $idKantin)
                ->select(
                    'transaksi.created_at as tanggal',
                    'transaksi.kode_tr',
                    'customer.nama as pembeli',
                    'user.username as kasir',
                    'kantin.nama as kantin',
                    'menu.harga_pokok as harga_pokok',
                    'menu.nama as pesanan',
                    'menu.harga as harga_satuan',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pengiriman'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

            $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $idKantin)
                ->select('detail_transaksi.QTY as jumlah')
                ->orderBy('transaksi.kode_tr', 'desc');

            if ($tglMulai == $tglSelesai) {
                $jumlah->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $jumlah = $jumlah->sum('detail_transaksi.QTY');

            $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('kantin.id_kantin', $idKantin);

            if ($tglMulai == $tglSelesai) {
                $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }


            $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('kantin.id_kantin', $idKantin);

            if ($tglMulai == $tglSelesai) {
                $sumTotalPokok->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotalPokok->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotal = $sumTotal->selectRaw('SUM(if(
        menu.diskon IS NULL OR menu.diskon = 0,
        menu.harga*QTY,
        (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
    )) as total')->value('total');
            $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
        menu.diskon IS NULL OR menu.diskon = 0,
        menu.harga_pokok*QTY,
        (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga*QTY))
    )) as total')->value('total');
            $pendapatan = $sumTotal - $sumTotalPokok;
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cekLaporan', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
                'idKantin' => $idKantin,
                'status' => $status
            ]);
        }
    }

    public function cetak($tglMulai, $tglSelesai, $idKantin, $status)
    {
        $tglSelesai = $tglSelesai . ' 23:59:00';
        $tglMulai = $tglMulai . ' 00:00:00';
        if (($idKantin != 'p') && ($status != 'p')) {
            # code

            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
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
                    'menu.harga_pokok as harga_pokok',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pengiriman'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

            $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $idKantin)
                ->where('transaksi.status_pengiriman', $status)
                ->select('detail_transaksi.QTY as jumlah')
                ->orderBy('transaksi.kode_tr', 'desc');

            if ($tglMulai == $tglSelesai) {
                $jumlah->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $jumlah = $jumlah->sum('detail_transaksi.QTY');


            $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('kantin.id_kantin', $idKantin)
                ->where('transaksi.status_pengiriman', $status);

            if ($tglMulai == $tglSelesai) {
                $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }
            $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('kantin.id_kantin', $idKantin)
                ->where('transaksi.status_pengiriman', $status);

            if ($tglMulai == $tglSelesai) {
                $sumTotalPokok->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotalPokok->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotal = $sumTotal->selectRaw('SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga*QTY,
            (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
        )) as total')->value('total');

            $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga_pokok*QTY,
            (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
        )) as total_pokok')->value('total_pokok');
            $pendapatan = $sumTotal - $sumTotalPokok;
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cetak', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
                'idKantin' => $idKantin,
                'status' => $status
            ]);
        } elseif (($idKantin == "p") && ($status == "p")) {
            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->select(
                    'transaksi.created_at as tanggal',
                    'transaksi.kode_tr',
                    'customer.nama as pembeli',
                    'user.username as kasir',
                    'kantin.nama as kantin',
                    'menu.nama as pesanan',
                    'menu.harga as harga_satuan',
                    'menu.harga_pokok as harga_pokok',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pengiriman'
                )
                ->orderBy('transaksi.created_at', 'desc');


            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

            $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')

                ->select('detail_transaksi.QTY as jumlah')
                ->orderBy('transaksi.kode_tr', 'desc');

            if ($tglMulai == $tglSelesai) {
                $jumlah->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $jumlah = $jumlah->sum('detail_transaksi.QTY');

            $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr');

            if ($tglMulai == $tglSelesai) {
                $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr');

            if ($tglMulai == $tglSelesai) {
                $sumTotalPokok->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotalPokok->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotal = $sumTotal->selectRaw('SUM(if(
        menu.diskon IS NULL OR menu.diskon = 0,
        menu.harga*QTY,
        (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
    )) as total')->value('total');
            $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
        menu.diskon IS NULL OR menu.diskon = 0,
        menu.harga_pokok*QTY,
        (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
    )) as total_pokok')->value('total_pokok');
            $pendapatan = $sumTotal - $sumTotalPokok;
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cetak', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
                'idKantin' => $idKantin,
                'status' => $status
            ]);

        } elseif (($idKantin == 'p') && ($status !== 'p')) {

            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')

                ->where('transaksi.status_pengiriman', $status)
                ->select(
                    'transaksi.created_at as tanggal',
                    'transaksi.kode_tr',
                    'customer.nama as pembeli',
                    'user.username as kasir',
                    'kantin.nama as kantin',
                    'menu.harga_pokok as harga_pokok',
                    'menu.nama as pesanan',
                    'menu.harga as harga_satuan',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pengiriman'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

            $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')

                ->where('transaksi.status_pengiriman', $status)
                ->select('detail_transaksi.QTY as jumlah')
                ->orderBy('transaksi.kode_tr', 'desc');

            if ($tglMulai == $tglSelesai) {
                $jumlah->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $jumlah = $jumlah->sum('detail_transaksi.QTY');

            $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')

                ->where('transaksi.status_pengiriman', $status);

            if ($tglMulai == $tglSelesai) {
                $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }
            $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('transaksi.status_pengiriman', $status);

            if ($tglMulai == $tglSelesai) {
                $sumTotalPokok->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotalPokok->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotal = $sumTotal->selectRaw('SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga*QTY,
            (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
        )) as total')->value('total');
            $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga_pokok*QTY,
            (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
        )) as total_pokok')->value('total_pokok');
            $pendapatan = $sumTotal - $sumTotalPokok;
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cetak', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
                'idKantin' => $idKantin,
                'status' => $status
            ]);
        } elseif (($idKantin !== 'p') && ($status == 'p')) {
            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $idKantin)
                ->select(
                    'transaksi.created_at as tanggal',
                    'transaksi.kode_tr',
                    'customer.nama as pembeli',
                    'user.username as kasir',
                    'kantin.nama as kantin',
                    'menu.harga_pokok as harga_pokok',
                    'menu.nama as pesanan',
                    'menu.harga as harga_satuan',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pengiriman'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

            $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $idKantin)
                ->select('detail_transaksi.QTY as jumlah')
                ->orderBy('transaksi.kode_tr', 'desc');

            if ($tglMulai == $tglSelesai) {
                $jumlah->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $jumlah = $jumlah->sum('detail_transaksi.QTY');

            $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('kantin.id_kantin', $idKantin);

            if ($tglMulai == $tglSelesai) {
                $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }


            $sumTotalPokok = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
                ->where('kantin.id_kantin', $idKantin);

            if ($tglMulai == $tglSelesai) {
                $sumTotalPokok->whereDate('detail_transaksi.created_at', $tglMulai);
            } else {
                $sumTotalPokok->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
            }

            $sumTotal = $sumTotal->selectRaw('SUM(if(
        menu.diskon IS NULL OR menu.diskon = 0,
        menu.harga*QTY,
        (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
    )) as total')->value('total');
            $sumTotalPokok = $sumTotalPokok->selectRaw('SUM(if(
        menu.diskon IS NULL OR menu.diskon = 0,
        menu.harga_pokok*QTY,
        (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga*QTY))
    )) as total')->value('total');
            $pendapatan = $sumTotal - $sumTotalPokok;
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
$tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cetak', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
                'idKantin' => $idKantin,
                'status' => $status
            ]);
        }


    }
}
