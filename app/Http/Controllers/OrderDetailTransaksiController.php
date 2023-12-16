<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderDetailTransaksiController extends Controller
{
    function __construct()
    {
        // $this->middleware('permission:orderdetailpenjualan-list|orderdetailpenjualan-edit|orderdetailpenjualan-delete', ['only' => ['index']]);
        // $this->middleware('permission:orderdetailpenjualan-edit', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:orderdetailpenjualan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // $data = Detail_penjualan::all()->orderBy('id', 'desc')
        //     ->get();
        $data = DetailTransaksi::select('detail_transaksi.kode_tr', 'detail_transaksi.QTY', 'detail_transaksi.subtotal_bayar', 'detail_transaksi.kode_menu', 'detail_transaksi.status_konfirm', 'transaksi.created_at', 'kantin.nama', 'menu.diskon')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->orderBy('detail_transaksi.kode_tr', 'desc')->get();
        // return $data;
        $title = 'detail penjualan';
        return view('dashboard.detail_penjualan.index', compact('data', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request, $id)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id, $id_menu)
    {
        $data = DetailTransaksi::select('detail_transaksi.kode_tr', 'detail_transaksi.QTY', 'detail_transaksi.subtotal_bayar', 'detail_transaksi.kode_menu', 'detail_transaksi.status_konfirm', 'transaksi.created_at', 'kantin.nama', 'menu.diskon')
            ->leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('detail_transaksi.kode_tr', $id)->where('kode_menu', $id_menu)->first();
        // return $data;
        $title = 'Edit Detail Penjualan';
        return view('dashboard.detail_penjualan.edit', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, $id_menu)
    {
        $data = DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->leftJoin('kantin', 'kantin.id_kantin', '=', 'menu.id_kantin')
            ->leftJoin('transaksi', 'transaksi.kode_tr', "=", 'detail_transaksi.kode_tr')
            ->where('detail_transaksi.kode_tr', $id)
            ->where('kode_menu', $id_menu)
            ->first();

        if (!$data) {
            return abort(404); // Or handle the case where the record is not found.
        }

        DetailTransaksi::leftJoin('menu', 'menu.id_menu', '=', 'detail_transaksi.kode_menu')
            ->where('detail_transaksi.kode_tr', $id)
            ->where('kode_menu', $id_menu)->update([
                    'status_konfirm' => $request->status,
                ]);

        return redirect('/detailpenjualan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = DetailTransaksi::find($id);
        $data->delete();
        return redirect('/detailpenjualan');
    }
}
