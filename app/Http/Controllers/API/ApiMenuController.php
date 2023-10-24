<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ApiMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(ApiKeyMiddleware::class);
    }

    // Controller Product

    public function productBestToday(Request $request)
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::now()->format('Y-m-d');

        if ($request->segment(4)) {
            $topSellingMenus = DB::table('menu')
                ->select('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'))
                ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                ->whereDate('transaksi.created_at', $today)
                ->where('menu.nama', 'LIKE', $request->segment(4) . '%')
                // ->where('menu.kategori', 'makanan')
                ->groupBy('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon')
                ->orderBy('penjualan_hari_ini', 'desc')
                ->limit(10)
                ->get();

            return $this->sendMassage($topSellingMenus, 200, true);
        } else {
            $topSellingMenus = DB::table('menu')
                ->select('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'))
                ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                ->whereDate('transaksi.created_at', $today)
                // ->where('menu.kategori', 'makanan')
                ->groupBy('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon')
                ->orderBy('penjualan_hari_ini', 'desc')
                ->limit(10)
                ->get();

            return $this->sendMassage($topSellingMenus, 200, true);
        }
    }

    public function productWithDiscount(Request $request)
    {
        // Mendapatkan tanggal hari ini
        $today = Carbon::now()->format('Y-m-d');

        if ($request->segment(4)) {
            $productDiscount = DB::table('menu')
                ->select('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'))
                ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                ->whereDate('transaksi.created_at', $today)
                ->where('menu.nama', 'LIKE', $request->segment(4) . '%')
                ->whereNotNull('menu.diskon') // Filter menu dengan diskon tidak null
                ->groupBy('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon')
                ->orderBy('penjualan_hari_ini', 'desc')
                ->limit(10)
                ->get();

            return $this->sendMassage($productDiscount, 200, true);
        } else {
            $productDiscount = DB::table('menu')
                ->select('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon', DB::raw('SUM(detail_transaksi.QTY) as penjualan_hari_ini'))
                ->join('detail_transaksi', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
                ->join('transaksi', 'detail_transaksi.kode_tr', '=', 'transaksi.kode_tr')
                ->whereDate('transaksi.created_at', $today)
                ->whereNotNull('menu.diskon') // Filter menu dengan diskon tidak null
                ->groupBy('menu.id_menu', 'menu.nama', 'menu.harga', 'menu.foto', 'menu.status_stok', 'menu.kategori', 'menu.id_kantin', 'menu.diskon')
                ->orderBy('penjualan_hari_ini', 'desc')
                ->limit(10)
                ->get();

            return $this->sendMassage($productDiscount, 200, true);
        }
    }

    public function product(Request $request)
    {
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', $request->segment(4) . '%')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->get(), 200, true);
        }
    }

    public function product_food(Request $request)
    {
        // dd($request->segment(3));
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', '%' . $request->segment(4) . '%')
                ->where('kategori', 'makanan')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->where('kategori', 'makanan')->get(), 200, true);
        }
    }

    public function product_drink(Request $request)
    {
        // dd($request->segment(4));
        if ($request->segment(4)) {
            return $this->sendMassage(Menu::select('id_menu', 'nama', 'harga', 'foto', 'status_stok', 'kategori', 'id_kantin', 'diskon', 'created_at', 'updated_at')
                ->where('nama', 'LIKE', $request->segment(4) . '%')
                ->where('kategori', 'minuman')
                ->where('status_stok', 'ada')
                ->get(), 200, true);
        } else {
            return $this->sendMassage(Menu::where('status_stok', 'ada')->where('kategori', 'minuman')->get(), 200, true);
        }

    }

    // Function Massage
    public function sendMassage($text, $kode, $status)
    {
        return response()->json([
            'data' => $text,
            'code' => $kode,
            'status' => $status
        ], $kode);
    }
}