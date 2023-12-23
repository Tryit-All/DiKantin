<?php

namespace App\Http\Controllers;

use App\Http\Middleware\KasirMiddleware;
use App\Models\Customer;
use App\Models\DetailTransaksi;
use App\Models\Kantin;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    function __construct()
    {
        $this->middleware([KasirMiddleware::class]);

    }

    public function index(Request $request)
    {
        $pencarian = $request->q;
        $customer = Customer::where('nama', 'Customer Offline')->first();
        $kantin = Kantin::all();
        $penjualan = Transaksi::all();
        $menu = Menu::where('nama', 'like', "%$pencarian%")->get();
        // dd($customer);
        // $menu = Menu::orderBy('id_kantin', 'asc')->get();

        return view('dashboard.kasir', [
            'title' => 'kasir',
            'customer' => $customer,
            'penjualan' => $penjualan,
            'kantin' => $kantin,
            'menu' => $menu
        ]);
    }

    public function reload($id, $datetime)
    {
        $data = DetailTransaksi::where('status', 'selesai')->get();
        $perubahan_data = $data->count();
    }
    // }
    /**
     * Show the form for creating a new resource.
     */
    public function struk($id)
    {
        $penjualan = Transaksi::with('detail_transaksi')->where('kode_tr', $id)->first();
        return view('dashboard.struk', [
            'penjualan' => $penjualan,
        ]);
    }
}
