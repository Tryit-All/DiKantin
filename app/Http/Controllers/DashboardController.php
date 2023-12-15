<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

class DashboardController extends Controller
{
    public function index()
    {
        $tanggalSekarang = Carbon::now();

        // $totalPendapatan = Transaksi::getTotalPendapatanByTanggal(date('Y-m-d'));
        $totalMenu = DetailTransaksi::whereDate('created_at', $tanggalSekarang)->sum('QTY');
        $Total_ongkir = Transaksi::whereDate('created_at', $tanggalSekarang)->where('status_pengiriman', 'terima')->sum('total_biaya_kurir');

        $jumlah_pendapatan_jual = DB::table('transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_bayar,
                    detail_transaksi.subtotal_bayar - (menu.diskon / 100 * detail_transaksi.subtotal_bayar)
                )) AS total,
                DATE_FORMAT(detail_transaksi.created_at, "%M") AS bulan,
                MONTH(detail_transaksi.created_at) AS bulan_num
            ')
            ->leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kurir')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereYear('transaksi.created_at', date('Y'))
            ->groupBy('bulan', 'bulan_num')
            ->orderBy('bulan_num', 'ASC')
            ->get()
            ->toArray();

        $jumlah_pendapatan_pokok = DB::table('transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total_pokok,
                DATE_FORMAT(detail_transaksi.created_at, "%M") AS bulan,
                MONTH(detail_transaksi.created_at) AS bulan_num
            ')
            ->leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kurir')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereYear('transaksi.created_at', date('Y'))
            ->groupBy('bulan', 'bulan_num')
            ->orderBy('bulan_num', 'ASC')
            ->get()
            ->toArray();

        $pendapatan = [];
        foreach ($jumlah_pendapatan_jual as $key => $value) {

            $tmp = [
                'total' => $value->total - (int) $jumlah_pendapatan_pokok[$key]->total_pokok,
                'bulan' => $value->bulan
            ];
            array_push($pendapatan, $tmp);
        }


        $nama_bulan = array(
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );

        // Ubah format nama bulan pada array $jumlah_pendapatan
        // foreach ($pendapatan as $data) {
        //     $data['bulan'] = $nama_bulan[date('n', strtotime($data->bulan)) - 1];
        // }

        // Gunakan label yang sudah diubah format namanya pada grafik
        // $label = $nama_bulan;
        // $label = array_column($pendapatan, 'bulan');

        $pendapatan_kantin1 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 1)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $pendapatan_kantin2 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 2)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $pendapatan_kantin3 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 3)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $pendapatan_kantin4 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 4)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $pendapatan_kantin5 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 5)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $pendapatan_kantin6 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 6)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $pendapatan_kantin7 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 7)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $pendapatan_kantin8 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 8)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $pendapatan_kantin9 = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('menu.id_kantin', '=', 9)
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->get();

        $sumTotal = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_bayar,
                    detail_transaksi.subtotal_bayar - (menu.diskon / 100 * detail_transaksi.subtotal_bayar)
                )) AS total
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->value('total');
        $sumTotalPokok = DB::table('detail_transaksi')
            ->selectRaw('
                SUM(IF(
                    menu.diskon IS NULL OR menu.diskon = 0,
                    detail_transaksi.subtotal_hargapokok,
                    detail_transaksi.subtotal_hargapokok - (menu.diskon / 100 * detail_transaksi.subtotal_hargapokok)
                )) AS total_pokok
            ')
            ->join('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->join('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('transaksi.status_pengiriman', '=', 'terima')
            ->whereDate('transaksi.tanggal', '=', now()->toDateString())
            ->value('total_pokok');
        $pendapatan_seluruh = $sumTotal - $sumTotalPokok;
        // dd($sumTotal);

        return view('dashboard.index', [
            'title' => 'Dashboard',
            // 'totalPendapatan' => $totalPendapatan,
            'totalMenu' => $totalMenu,
            // 'jumlah_pendapatan' => $jumlah_pendapatan,
            'pendapatan' => $pendapatan,
            'Total_ongkir' => $Total_ongkir,

            'kantin1' => $pendapatan_kantin1,
            'kantin2' => $pendapatan_kantin2,
            'kantin3' => $pendapatan_kantin3,
            'kantin4' => $pendapatan_kantin4,
            'kantin5' => $pendapatan_kantin5,
            'kantin6' => $pendapatan_kantin6,
            'kantin7' => $pendapatan_kantin7,
            'kantin8' => $pendapatan_kantin8,
            'kantin9' => $pendapatan_kantin9,
            'sumTotal' => $sumTotal,
            'pendapatan_seluruh' => $pendapatan_seluruh,

        ]);
    }
}
