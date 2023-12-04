<?php

namespace App\Http\Controllers;

use App\Events\OrderNotification;
use App\Models\DetailTransaksi;
use App\Models\Menu;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PenjualanController extends Controller
{
    public function allData(Request $req)
    {

        $data = Transaksi::all();

        foreach ($data as $key => $item) {
            $builder = new DetailTransaksi();

            $builder = $builder->where('id_penjualan', $item->id);

            if ($req->id_kantin) {
                $builder = $builder->where('id_kantin', $req->id_kantin);
            }

            if ($req->status) {
                $builder = $builder->where('status', $req->status);
            }

            $details = $builder->get();

            $data[$key]->details = $details;
        }

        return response()->json($data);

    }

    public function index()
    {
        $penjualan = Transaksi::all();
        return view('dashboard.penjualan.index', [
            'title' => 'penjualan',
            'penjualan' => $penjualan
        ]);
    }

    public function tambahJumlah(Request $request)
    {
        $detail = DetailTransaksi::find($request->id);

        $jumlah = $detail->jumlah + 1;

        $harga = $detail->menus->harga * $jumlah;

        $data['jumlah'] = $jumlah;
        $data['harga'] = $harga;

        $detail->update($data);

        return response(true);
    }

    public function kurangJumlah(Request $request)
    {
        $detail = DetailTransaksi::find($request->id);

        $jumlah = $detail->jumlah - 1;

        $harga = $detail->menus->harga * $jumlah;

        $data['jumlah'] = $jumlah;
        $data['harga'] = $harga;

        $detail->update($data);

        return response(true);
    }

    public function hapusItem(Request $request)
    {
        $detail = DetailTransaksi::find($request->id)->delete();
        return response(true);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $dataDetailOrderan = $request->details;
        $idCust = $request->id_customer;
        $total_bayar = $request->bayar;
        $total_harga = $request->total;
        $kembalian = $request->kembalian;
        $model_pembayaran = $request->model_pembayaran;
        $noMeja = $request->no_meja;

        $today = Carbon::now();

        $RandomNumber = rand(1000, 9999);
        $kodeTr = "TRDKN" . $RandomNumber;

        $Transaksi = new Transaksi();
        $Transaksi->kode_tr = $kodeTr;
        $Transaksi->status_konfirm = "1";
        $Transaksi->status_pesanan = "1";
        $Transaksi->tanggal = $today;
        $Transaksi->id_customer = $idCust;
        $Transaksi->total_bayar = $total_bayar;
        $Transaksi->total_harga = $total_harga;
        $Transaksi->kembalian = $kembalian;
        $Transaksi->status_pengiriman = "proses";
        $Transaksi->model_pembayaran = $model_pembayaran;
        $Transaksi->no_meja = $noMeja;
        $Transaksi->expired_at = now()->addMinutes(1);
        $Transaksi->save();

        foreach ($dataDetailOrderan as $key => $value) {
            $jumlah = $value['jumlah'];
            $hargaBarang = $value['harga'];
            $subTotal = $jumlah * $hargaBarang;

            $detail = new DetailTransaksi();
            $detail->kode_tr = $kodeTr;
            $detail->kode_menu = $value['id_menu'];
            $detail->QTY = $value['jumlah'];
            $detail->subtotal_bayar = $subTotal;
            $detail->save();
        }

        // dd($request);
        // kayane wis bener, tinggal buat request ajaxnya ke route yang dideifinisikan

        return response()->json([
            'status' => true,
            'message' => "Berhasil",
            'data' => [
                'id' => $kodeTr,

            ]
        ], 200)
            ->header('Content-Type', 'application/json');

    }
}