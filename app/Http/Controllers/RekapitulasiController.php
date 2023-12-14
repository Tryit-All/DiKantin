<?php

namespace App\Http\Controllers;

use App\Exports\RekapitulasiExport;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;

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
        $dataQuery = DetailTransaksi::with([
            'Menu.Kantin:id,nama_kantin',
        ])
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima');



        $data = $dataQuery->selectRaw(
            "transaksi.kode_tr as kode, kantin.id_kantin as id_kantin,
            kantin.nama as nama_kantin,

            SUM(menu.harga) as harga_satuan,
            SUM(detail_transaksi.QTY) as jumlah,
            SUM(menu.diskon) as diskon,
            SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga * detail_transaksi.QTY,
                (menu.harga * detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga * detail_transaksi.QTY))
            )) as total, transaksi.model_pembayaran as metode,
            SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok * detail_transaksi.QTY,
                (menu.harga_pokok * detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga_pokok * detail_transaksi.QTY))
            )) as total_hargapokok, transaksi.model_pembayaran as metode"

        )
            ->groupBy('kantin.id_kantin', 'kantin.nama', 'transaksi.model_pembayaran', 'transaksi.kode_tr')
            ->orderBy('kantin.id_kantin', 'asc')->whereDate('transaksi.created_at', now()->toDateString())
            ->get()->toArray();

        $jumlahQuery = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')->whereDate('transaksi.created_at', now()->toDateString())
            ->where('transaksi.status_pengiriman', 'terima');


        $jumlah = $jumlahQuery
            ->selectRaw('SUM(detail_transaksi.QTY) as jumlah')
            ->orderBy('transaksi.kode_tr', 'asc')
            ->value('jumlah');

        $sumTotalQuery = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString())
            ->where('transaksi.status_pengiriman', 'terima');
        $sumTotalPokokQuery = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString())
            ->where('transaksi.status_pengiriman', 'terima');

        $sumTotal = $sumTotalQuery
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')
            ->value('total');
        $sumTotalPokok = $sumTotalPokokQuery
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok*QTY,
                (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
            )) as total_pokok')
            ->value('total_pokok');
        $pendapatan = $sumTotal - $sumTotalPokok;
        return view('dashboard.rekapitulasi.index', compact(['data', 'jumlah', 'sumTotal', 'sumTotalPokok', 'pendapatan']));
    }

    public function cekRekapitulasi($tglMulai, $tglSelesai)
    {
        $tglSelesai = $tglSelesai . ' 23:59:00';
        $tglMulai = $tglMulai . ' 00:00:00';
        $dataQuery = DetailTransaksi::with([
            'Menu.Kantin:id,nama_kantin',
        ])
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima');

        if ($tglMulai === $tglSelesai) {
            $dataQuery->whereDate('detail_transaksi.created_at', $tglMulai);
        } else {
            $dataQuery->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai]);
        }

        $data = $dataQuery->selectRaw(
            "transaksi.kode_tr as kode, kantin.id_kantin as id_kantin,
            kantin.nama as nama_kantin,
            SUM(menu.harga) as harga_satuan,
            SUM(detail_transaksi.QTY) as jumlah,
            SUM(menu.diskon) as diskon,
            SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga * detail_transaksi.QTY,
                (menu.harga * detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga * detail_transaksi.QTY))
            )) as total, transaksi.model_pembayaran as metode,
            SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok * detail_transaksi.QTY,
                (menu.harga_pokok* detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga_pokok* detail_transaksi.QTY))
            )) as total_hargapokok, transaksi.model_pembayaran as metode"
        )
            ->groupBy('kantin.id_kantin', 'kantin.nama', 'transaksi.model_pembayaran', 'transaksi.kode_tr')
            ->orderBy('kantin.id_kantin', 'asc')
            ->get()->toArray();


        $jumlahQuery = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->where('transaksi.status_pengiriman', 'terima');

        if ($tglMulai === $tglSelesai) {
            $jumlahQuery->whereDate('detail_transaksi.created_at', $tglMulai);
        } else {
            $jumlahQuery->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai]);
        }
        $jumlah = $jumlahQuery
            ->selectRaw('SUM(detail_transaksi.QTY) as jumlah')
            ->orderBy('transaksi.kode_tr', 'asc')
            ->value('jumlah');

        $sumTotalQuery = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima');
        if ($tglMulai === $tglSelesai) {
            $sumTotalQuery->whereDate('detail_transaksi.created_at', $tglMulai);
        } else {
            $sumTotalQuery->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai]);
        }
        $sumTotal = $sumTotalQuery
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')
            ->value('total');
        $sumTotalPokokQuery = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima');
        if ($tglMulai === $tglSelesai) {
            $sumTotalPokokQuery->whereDate('detail_transaksi.created_at', $tglMulai);
        } else {
            $sumTotalPokokQuery->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai]);
        }
        $sumTotalPokok = $sumTotalPokokQuery
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok*QTY,
                (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
            )) as total_pokok')
            ->value('total_pokok');

        // return $data;
        $pendapatan = $sumTotal - $sumTotalPokok;
        $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
        $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
        return view(
            'dashboard.rekapitulasi.cekRekapitulasi',
            [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'jumlah' => $jumlah,
                'pendapatan' => $pendapatan,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
            ]
        );
    }

    public function cetak($tglMulai, $tglSelesai)
    {
        $tglSelesai = $tglSelesai . ' 23:59:00';
        $tglMulai = $tglMulai . ' 00:00:00';
        $dataQuery = DetailTransaksi::with([
            'Menu.Kantin:id,nama_kantin',
        ])
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima');

        if ($tglMulai === $tglSelesai) {
            $dataQuery->whereDate('detail_transaksi.created_at', $tglMulai);
        } else {
            $dataQuery->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai]);
        }

        $data = $dataQuery->selectRaw(
            "transaksi.kode_tr as kode, kantin.id_kantin as id_kantin,
            kantin.nama as nama_kantin,
            SUM(menu.harga) as harga_satuan,
            SUM(detail_transaksi.QTY) as jumlah,
            SUM(menu.diskon) as diskon,
            SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga * detail_transaksi.QTY,
                (menu.harga * detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga * detail_transaksi.QTY))
            )) as total, transaksi.model_pembayaran as metode,
            SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok * detail_transaksi.QTY,
                (menu.harga_pokok* detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga_pokok* detail_transaksi.QTY))
            )) as total_hargapokok, transaksi.model_pembayaran as metode"
        )
            ->groupBy('kantin.id_kantin', 'kantin.nama', 'transaksi.model_pembayaran', 'transaksi.kode_tr')
            ->orderBy('kantin.id_kantin', 'asc')
            ->get()->toArray();


        $jumlahQuery = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->where('transaksi.status_pengiriman', 'terima');

        if ($tglMulai === $tglSelesai) {
            $jumlahQuery->whereDate('detail_transaksi.created_at', $tglMulai);
        } else {
            $jumlahQuery->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai]);
        }
        $jumlah = $jumlahQuery
            ->selectRaw('SUM(detail_transaksi.QTY) as jumlah')
            ->orderBy('transaksi.kode_tr', 'asc')
            ->value('jumlah');

        $sumTotalQuery = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima');
        if ($tglMulai === $tglSelesai) {
            $sumTotalQuery->whereDate('detail_transaksi.created_at', $tglMulai);
        } else {
            $sumTotalQuery->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai]);
        }
        $sumTotal = $sumTotalQuery
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')
            ->value('total');
        $sumTotalPokokQuery = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima');
        if ($tglMulai === $tglSelesai) {
            $sumTotalPokokQuery->whereDate('detail_transaksi.created_at', $tglMulai);
        } else {
            $sumTotalPokokQuery->whereBetween('detail_transaksi.created_at', [$tglMulai, $tglSelesai]);
        }
        $sumTotalPokok = $sumTotalPokokQuery
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok*QTY,
                (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
            )) as total_pokok')
            ->value('total_pokok');

        // return $data;
        $pendapatan = $sumTotal - $sumTotalPokok;
        $tglSelesai = Carbon::parse($tglSelesai)->format('Y-m-d');
        $tglMulai = Carbon::parse($tglMulai)->format('Y-m-d');
        return view(
            'dashboard.rekapitulasi.cetak',
            [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'sumTotalPokok' => $sumTotalPokok,
                'jumlah' => $jumlah,
                'pendapatan' => $pendapatan,
                'tglMulai' => $tglMulai,
                'tglSelesai' => $tglSelesai,
            ]
        );
    }
    public function cetakSemua()
    {
        $dataQuery = DetailTransaksi::with([
            'Menu.Kantin:id,nama_kantin',
        ])
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->where('transaksi.status_pengiriman', 'terima');



        $data = $dataQuery->selectRaw(
            "transaksi.kode_tr as kode, kantin.id_kantin as id_kantin,
            kantin.nama as nama_kantin,

            SUM(menu.harga) as harga_satuan,
            SUM(detail_transaksi.QTY) as jumlah,
            SUM(menu.diskon) as diskon,
            SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga * detail_transaksi.QTY,
                (menu.harga * detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga * detail_transaksi.QTY))
            )) as total, transaksi.model_pembayaran as metode,
            SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok * detail_transaksi.QTY,
                (menu.harga_pokok * detail_transaksi.QTY) - (menu.diskon/100 * (menu.harga_pokok * detail_transaksi.QTY))
            )) as total_hargapokok, transaksi.model_pembayaran as metode"

        )
            ->groupBy('kantin.id_kantin', 'kantin.nama', 'transaksi.model_pembayaran', 'transaksi.kode_tr')
            ->orderBy('kantin.id_kantin', 'asc')->whereDate('transaksi.created_at', now()->toDateString())
            ->get();

        $jumlahQuery = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')->whereDate('transaksi.created_at', now()->toDateString())
            ->where('transaksi.status_pengiriman', 'terima');


        $jumlah = $jumlahQuery
            ->selectRaw('SUM(detail_transaksi.QTY) as jumlah')
            ->orderBy('transaksi.kode_tr', 'asc')
            ->value('jumlah');

        $sumTotalQuery = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString())
            ->where('transaksi.status_pengiriman', 'terima');
        $sumTotalPokokQuery = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')->whereDate('transaksi.created_at', now()->toDateString())
            ->where('transaksi.status_pengiriman', 'terima');

        $sumTotal = $sumTotalQuery
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga*QTY,
                (menu.harga*QTY) - (menu.diskon/100*(menu.harga*QTY))
            )) as total')
            ->value('total');
        $sumTotalPokok = $sumTotalPokokQuery
            ->selectRaw('SUM(if(
                menu.diskon IS NULL OR menu.diskon = 0,
                menu.harga_pokok*QTY,
                (menu.harga_pokok*QTY) - (menu.diskon/100*(menu.harga_pokok*QTY))
            )) as total_pokok')
            ->value('total_pokok');
        $pendapatan = $sumTotal - $sumTotalPokok;

        return view(
            'dashboard.rekapitulasi.cetaksemua',
            [
                'data' => $data,
                'sumTotal' => $sumTotal,
                'jumlah' => $jumlah,
                'pendapatan' => $pendapatan,
                'sumTotalPokok' => $sumTotalPokok,

            ]
        );
    }


    public function excel(Request $request)
    {
        $data = $request->input('data');
        $dataAsArray = json_decode($data);
        return FacadesExcel::download(new RekapitulasiExport($dataAsArray, $request->input('sum_total_pokok'), $request->input('pendapatan')), "rekapitulasi." . $request->input('type'));
    }

}
