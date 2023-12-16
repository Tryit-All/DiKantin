<?php

namespace App\Http\Controllers;

use App\Exports\LaporanExport;
use App\Http\Middleware\AdminDLLMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DwpMiddleware;
use App\Http\Middleware\TefaMiddleware;
use App\Models\DetailTransaksi;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Kantin;
use App\Models\Transaksi;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    function __construct()
    {
        $this->middleware([AdminDLLMiddleware::class]);
    }

    public function index()
    {
        $kantin = Kantin::all();
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
                'status_pengiriman',
                'detail_transaksi.subtotal_bayar as subtotal',
                'detail_transaksi.subtotal_hargapokok as subtotalpokok'
            )
            ->orderBy('transaksi.created_at', 'desc')->whereDate('transaksi.created_at', now()->toDateString())
            ->get()->toArray();
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
        $komisi_jti = $pendapatan * (45 / 100);
        $komisi_dwp = $pendapatan * (55 / 100);

        return view(
            'dashboard.laporan.index',
            compact(['data', 'jumlah', 'sumTotal', 'sumTotalPokok', 'pendapatan', 'kantin', 'komisi_dwp', 'komisi_jti'])
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
        $kantin = Kantin::all();
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
                    'status_pengiriman',
                    'detail_transaksi.subtotal_bayar as subtotal',
                    'detail_transaksi.subtotal_hargapokok as subtotalpokok'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();
            $first = $data->first();
            $first = $data->first();
        
            if ($first == null) {
                Alert::error('Tidak ada', 'Tidak Ada Laporan Untuk Kantin ini dengan status '.$status);
                return back();
            }else {
                # code...
                $nama_kantin = $first->kantin;
            }
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
            $komisi_jti = $pendapatan * (45 / 100);
            $komisi_dwp = $pendapatan * (55 / 100);
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cekLaporan', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,
                'nama_kantin' => $nama_kantin,
                'komisi_jti' => $komisi_jti,
                'komisi_dwp' => $komisi_dwp,
                'kantin' => $kantin,
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
                    'status_pengiriman',
                    'detail_transaksi.subtotal_bayar as subtotal',
                    'detail_transaksi.subtotal_hargapokok as subtotalpokok'
                )
                ->orderBy('transaksi.created_at', 'desc');


            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();
            $first = $data->first();
        
            if ($first == null) {
                Alert::error('Tidak ada', 'Tidak Ada Laporan Untuk Tanggal Yang dicari');
                return back();
            }else {
                # code...
          
                $nama_kantin = "Semua Kantin";
            }
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
            $komisi_jti = $pendapatan * (45 / 100);
            $komisi_dwp = $pendapatan * (55 / 100);
            return view('dashboard.laporan.cekLaporan', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,
                'nama_kantin' => $nama_kantin,
                'komisi_jti' => $komisi_jti,
                'komisi_dwp' => $komisi_dwp,
                'kantin' => $kantin,
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
                    'status_pengiriman',
                    'detail_transaksi.subtotal_bayar as subtotal',
                    'detail_transaksi.subtotal_hargapokok as subtotalpokok'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();
            $first = $data->first();
        
            if ($first == null) {
                Alert::error('Tidak ada', 'Tidak Ada Laporan Untuk Status Yang diberikan');
                return back();
            }else {
                # code...
          
                $nama_kantin = "Semua Kantin";
            }

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
            $komisi_jti = $pendapatan * (45 / 100);
            $komisi_dwp = $pendapatan * (55 / 100);
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
            return view('dashboard.laporan.cekLaporan', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,
                'nama_kantin' => $nama_kantin,
                'komisi_jti' => $komisi_jti,
                'komisi_dwp' => $komisi_dwp,
                'kantin' => $kantin,
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
                    'status_pengiriman',
                    'detail_transaksi.subtotal_bayar as subtotal',
                    'detail_transaksi.subtotal_hargapokok as subtotalpokok'
                )
                ->orderBy('transaksi.created_at', 'desc');

            if ($tglMulai == $tglSelesai) {
                $data->whereDate('transaksi.created_at', $tglMulai);
            } else {
                $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
            }

            $data = $data->get();

        
            $first = $data->first();
        
            if ($first == null) {
                Alert::error('Tidak ada', 'Tidak Ada Laporan Untuk Kantin Yang dicari');
                return back();
            }else {
                # code...
                $nama_kantin = $first->kantin;
            }

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
            $komisi_jti = $pendapatan * (45 / 100);
            $komisi_dwp = $pendapatan * (55 / 100);
            $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
            $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');

            return view('dashboard.laporan.cekLaporan', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,
                'nama_kantin' => $nama_kantin,
                'komisi_jti' => $komisi_jti,
                'komisi_dwp' => $komisi_dwp,
                'kantin' => $kantin,
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
            dd($data);
            return view('dashboard.laporan.cetak', [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'pendapatan' => $pendapatan,

                'jumlah' => $jumlah,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
            ]);
        }

        // $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
        //     ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
        //     ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
        //     ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
        //     ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
        //     ->where('kantin.id_kantin', $idKantin)
        //     ->where('transaksi.status_pengiriman', $status)
        //     ->select(
        //         'transaksi.created_at as tanggal',
        //         'transaksi.kode_tr',
        //         'customer.nama as pembeli',
        //         'user.username as kasir',
        //         'kantin.nama as kantin',
        //         'menu.nama as pesanan',
        //         'menu.harga as harga_satuan',
        //         'detail_transaksi.QTY as jumlah',
        //         'menu.diskon as diskon',
        //         'status_pengiriman'
        //     )
        //     ->orderBy('transaksi.kode_tr', 'desc');

        // if ($tglMulai == $tglSelesai) {
        //     $data->whereDate('transaksi.created_at', $tglMulai);
        // } else {
        //     $data->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
        // }

        // $data = $data->get();

        // $jumlah = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
        //     ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
        //     ->leftJoin('detail_transaksi', 'transaksi.Kode_tr', '=', 'detail_transaksi.kode_tr')
        //     ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
        //     ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
        //     ->where('kantin.id_kantin', $idKantin)
        //     ->where('transaksi.status_pengiriman', $status)
        //     ->select('detail_transaksi.QTY as jumlah')
        //     ->orderBy('transaksi.kode_tr', 'desc');

        // if ($tglMulai == $tglSelesai) {
        //     $jumlah->whereDate('transaksi.created_at', $tglMulai);
        // } else {
        //     $jumlah->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai]);
        // }

        // $jumlah = $jumlah->sum('detail_transaksi.QTY');

        // $sumTotal = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
        //     ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
        //     ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
        //     ->where('kantin.id_kantin', $idKantin)
        //     ->where('transaksi.status_pengiriman', $status);

        // if ($tglMulai == $tglSelesai) {
        //     $sumTotal->whereDate('detail_transaksi.created_at', $tglMulai);
        // } else {
        //     $sumTotal->whereRaw("detail_transaksi.created_at BETWEEN '" . $tglMulai . "' AND '" . $tglSelesai . "'");
        // }

        // $sumTotal = $sumTotal->selectRaw('SUM(if(
        //     menu.diskon IS NULL OR menu.diskon = 0,
        //     menu.harga*QTY,
        //     (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
        // )) as total')->value('total');

        // return view('dashboard.laporan.cetak', [
        //     'data' => $data,
        //     'sumTotal' => $sumTotal,
        //     'jumlah' => $jumlah,
        //     'tglMulai' => $tglMulai,
        //     'tglSelesai' => $tglSelesai,
        // ]);
    }

    public function cetakExcel(Request $request)
    {

        return Excel::download(new LaporanExport($request->input('data'), $request->input('total_pokok'), $request->input('pendapatan'), $request->input('totalJual')), "laporan." . $request->input('type'));
    }
}
