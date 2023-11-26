<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use Illuminate\Http\Request;

class OrderDetailTransaksiController extends Controller
{
    public function index()
    {
        // $data = Detail_penjualan::all()->orderBy('id', 'desc')
        //     ->get();
        $data = DB::table('detail_penjualans')->orderBy('id', 'desc')->get();
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
    public function edit(Request $request, $id)
    {
        $data = DetailTransaksi::findOrFail($id);
        $title = 'Edit Detail Penjualan';
        return view('dashboard.detail_penjualan.edit', compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $data = DetailTransaksi::find($id);
        $data->update($request->all());
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
