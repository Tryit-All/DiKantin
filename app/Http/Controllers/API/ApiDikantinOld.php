<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ApiDikantinOld extends Controller
{
    public function api_riwayat(Request $request)
    {
        if ($request->has('id_kantin')) {
            $id_kantin = $request->input('id_kantin');

            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', '=', $id_kantin)
                ->where('status_pengiriman', 'terima')
                ->orderBy('transaksi.created_at', 'desc')
                ->select(
                    'menu.foto as foto',
                    'detail_transaksi.kode_tr AS id_detail,',
                    'transaksi.created_at as tanggal',
                    'transaksi.kode_tr',
                    'customer.nama as pembeli',
                    'customer.no_telepon as no_telepon_pembeli',
                    'user.username AS kasir',
                    'model_pembayaran',
                    'no_meja',
                    'kantin.nama as kantin',
                    'menu.nama as pesanan',
                    'menu.harga as harga_satuan',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pesanan as status'
                )
                ->get();

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    public function apiByStatusAndDate(Request $request, $status)
    {
        // Cek apakah parameter ID kantin telah diberikan
        if ($request->has('id_kantin')) {
            $id_kantin = $request->input('id_kantin');

            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $id_kantin)
                ->where('status_pengiriman', $status)
                ->whereDate('transaksi.created_at', Carbon::now()->format('d'))
                ->orderBy('transaksi.created_at', 'desc')
                ->select(
                    'menu.foto as foto',
                    'detail_transaksi.kode_tr AS id_detail,',
                    'transaksi.created_at as tanggal',
                    'transaksi.kode_tr',
                    'customer.nama as pembeli',
                    'customer.no_telepon as no_telepon_pembeli',
                    'user.username AS kasir',
                    'model_pembayaran',
                    'no_meja',
                    'kantin.nama as kantin',
                    'menu.nama as pesanan',
                    'menu.harga as harga_satuan',
                    'detail_transaksi.QTY as jumlah',
                    'menu.diskon as diskon',
                    'status_pesanan as status'
                )
                ->get();

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    // Contoh penggunaan
    public function apisucces_date(Request $request)
    {
        if ($request->has('id_kantin')) {
            $id_kantin = $request->input('id_kantin');

            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $id_kantin)
                ->where('status_pengiriman', 'terima')
                ->whereDate('transaksi.created_at', Carbon::now()->format('Y-m-d'))
                ->orderBy('transaksi.created_at', 'desc')
                ->count();

            return $this->sendMassage((string) $data, 200, true);
        } else {
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    public function apiproses_date(Request $request)
    {
        if ($request->has('id_kantin')) {
            $id_kantin = $request->input('id_kantin');

            $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
                ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
                ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('kantin.id_kantin', $id_kantin)
                ->where('status_pengiriman', 'proses')
                ->whereDate('transaksi.created_at', Carbon::now()->format('Y-m-d'))
                ->orderBy('transaksi.created_at', 'desc')
                ->count();

            return $this->sendMassage((string) $data, 200, true);
        } else {
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    public function menuTerlaris(Request $request)
    {
        if ($request->has('id_kantin')) {
            $id_kantin = $request->input('id_kantin');

            $month = Carbon::now()->format('m');
            $year = Carbon::now()->format('Y');

            $data = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('menu.id_kantin', '=', $id_kantin)
                ->whereMonth('detail_transaksi.created_at', $month)
                ->whereYear('detail_transaksi.created_at', $year)
                ->select('menu.nama as pesanan')
                ->orderByRaw('SUM(detail_transaksi.QTY) DESC')
                ->groupBy('menu.id_menu')
                ->take(5)
                ->get();

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    public function api_jumlah_penjualan_bulan_ini(Request $request)
    {
        if ($request->has('id_kantin')) {
            $id_kantin = $request->input('id_kantin');

            $data = DetailTransaksi::leftJoin('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('menu.id_kantin', '=', $id_kantin)
                ->where('transaksi.status_pengiriman', 'terima')
                ->whereMonth('transaksi.created_at', Carbon::now()->format('m'))
                ->whereYear('transaksi.created_at', Carbon::now()->format('Y'))
                ->selectRaw('SUM(detail_transaksi.subtotal_bayar) as total')
                ->value('total');

            return response()->json(['jumlah_penjualan' => (string) $data]);
        } else {
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    public function api_jumlah_penjualan_hari_ini(Request $request)
    {
        if ($request->has('id_kantin')) {
            $id_kantin = $request->input('id_kantin');

            $data = DetailTransaksi::leftJoin('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
                ->where('menu.id_kantin', '=', $id_kantin)
                ->where('transaksi.status_pengiriman', 'terima')
                ->whereDate('transaksi.created_at', Carbon::now()->format('d'))
                ->selectRaw('SUM(detail_transaksi.subtotal_bayar) as total')
                ->value('total');

            return response()->json(['jumlah_penjualan' => (string) $data]);
        } else {
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    public function Statistik(Request $request)
    {
        if ($request->has('id_kantin')) {
            $id_kantin = $request->input('id_kantin');

            $data = DetailTransaksi::leftJoin('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
                ->leftJoin('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
                ->leftJoin('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')
                ->where('kantin.id_kantin', $id_kantin)
                ->where('transaksi.status_pengiriman', 'terima')
                ->whereMonth('transaksi.created_at', Carbon::now()->format('m'))
                ->whereYear('transaksi.created_at', Carbon::now()->format('Y'))
                ->selectRaw('SUM(detail_transaksi.QTY) as jumlah, DAY(transaksi.created_at) as tanggal')
                ->groupByRaw('DAY(transaksi.created_at)')
                ->get();

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Parameter ID kantin tidak diberikan']);
        }
    }

    public function rentangPendapatan(Request $request)
    {
        $tglMulai = $request->input('tanggalMulai');
        $tglSelesai = $request->input('tanggalSelesai');
        $idKantin = $request->input('id_kantin');

        $data = Transaksi::leftJoin('customer', 'customer.id_customer', '=', 'transaksi.id_customer')
            ->leftJoin('detail_transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
            ->leftJoin('kantin', 'menu.id_kantin', '=', 'kantin.id_kantin')
            ->leftJoin('user', 'user.id_user', '=', 'transaksi.id_kasir')
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->where('kantin.id_kantin', $idKantin)
            ->where('transaksi.status_pengiriman', 'terima')
            ->select(
                'transaksi.created_at as tanggal',
                'transaksi.kode_tr as nomer_penjualan',
                'customer.nama as pembeli',
                'user.username as kasir',
                'kantin.nama as kantin',
                'menu.nama as pesanan',
                'menu.harga as harga_satuan',
                'detail_transaksi.QTY as jumlah',
                'menu.diskon as diskon',
                'transaksi.status_pengiriman as status'
            )
            ->orderBy('transaksi.created_at', 'desc')
            ->get();

        // dd($data);

        $sumTotal = DetailTransaksi::leftJoin('transaksi', 'transaksi.kode_tr', '=', 'detail_transaksi.kode_tr')
            ->leftJoin('menu', 'detail_transaksi.kode_menu', '=', 'menu.id_menu')
            ->where('menu.id_kantin', $idKantin)
            ->whereBetween('transaksi.created_at', [$tglMulai, $tglSelesai])
            ->selectRaw('SUM(IF(
            menu.diskon IS NULL OR menu.diskon = 0,
            menu.harga * detail_transaksi.QTY,
            (menu.harga * detail_transaksi.QTY) - (menu.diskon / 100 * (menu.harga * detail_transaksi.QTY))
        )) as total')
            ->value('total');

        $totalPenjualan = 0;
        foreach ($data as $item) {
            $totalPenjualan += ($item->harga_satuan * $item->jumlah) - $item->diskon;
        }

        return response()->json([
            'data' => $data,
            'sumTotal' => $sumTotal,
            'totalPenjualan' => $totalPenjualan,
        ]);
    }

    public function updateStatusPenjualan(Request $request)
    {
        if ($request->has('id_detail')) {
            $id_detail = $request->input('id_detail');

            DetailTransaksi::where('id', '=', $id_detail)
                ->update(['status_konfirm' => 'selesai']);

            return response()->json(['success' => 'Status penjualan berhasil diubah']);
        } else {
            return response()->json(['error' => 'Parameter ID detail penjualan tidak diberikan']);
        }
    }

    public function updateHabis(Request $request)
    {
        if ($request->has('id_menu')) {
            $id = $request->input('id_menu');

            Menu::where('id_menu', '=', $id)
                ->update(['status_stok' => 'tidak ada']);

            return response()->json(['success' => 'Status menu berhasil diubah']);
        } else {
            return response()->json(['error' => 'Parameter ID menu tidak diberikan']);
        }
    }

    public function barangAda()
    {
        $barangAda = DetailTransaksi::where('status_konfirm', 'proses')->get();
        $dataBarang = $barangAda->count();

        return response()->json($dataBarang);
    }

    public function barangHabis()
    {
        $barangHabis = Menu::where('status_stok', 'tidak ada')->get();

        return response()->json($barangHabis);
    }

    public function updateAda(Request $request)
    {
        if ($request->has('id_menu')) {
            $id = $request->input('id_menu');

            Menu::where('id_menu', '=', $id)
                ->update(['status_stok' => 'ada']);

            return response()->json(['success' => 'Status menu berhasil diubah']);
        } else {
            return response()->json(['error' => 'Parameter ID menu tidak diberikan']);
        }
    }

    public function ubahHarga()
    {
        $barangSelesai = DetailTransaksi::where('status_konfirm', 'selesai')->get();
        $dataBarang = $barangSelesai->count();

        return response()->json($dataBarang);
    }

    public function orderSelesai()
    {
        $orderSelesai = DetailTransaksi::where('status_konfirm', 'selesai')->get();
        $orderCount = $orderSelesai->count();

        return response()->json($orderCount);
    }

    public function menuAda()
    {
        $menuAda = Menu::where('status_stok', 'ada')->get();
        $dataBarang = $menuAda->count();

        return response()->json($dataBarang);
    }

    public function sendMassage($text, $kode, $status)
    {
        return response()->json([
            'data' => $text,
            'code' => $kode,
            'status' => $status
        ], $kode);
    }
}