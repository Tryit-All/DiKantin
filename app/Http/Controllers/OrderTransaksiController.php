<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class OrderTransaksiController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:orderpenjualan-list|orderpenjualan-edit|orderpenjualan-delete', ['only' => ['index']]);
        $this->middleware('permission:orderpenjualan-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:orderpenjualan-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        // $data = Penjualan::all();
        $data = Transaksi::orderBy('kode_tr', 'desc')->get();
        return view('dashboard.penjualan.index', [
            'data' => $data,
            'title' => 'data'
        ]);
        return response()->json(['message' => 'success', 'menu' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Transaksi::findOrFail($id);
        $title = 'Edit Penjualan';
        return view('dashboard.penjualan.edit', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $data = Transaksi::find($id);
        // $data->id_customer = $request->id_customer;
        // $data->nama = $request->nama;
        // $data->alamat = $request->alamat;
        // $data->no_telepon = $request->no_telepon;
        // $data->save();
        $data->update($request->all());
        return redirect('/penjualan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $data = Transaksi::find($id);
        $data->delete();
        return redirect('/penjualan');
    }
}
