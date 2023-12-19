<?php

namespace App\Http\Controllers;

use App\Exports\HistoryKantinExport;
use App\Models\History;
use App\Models\Kantin;
use App\Models\Kurir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class KeuanganController extends Controller
{
    //
    public function index()
    {
        $kantin = Kantin::with('history')->get();
        $kurir = Kurir::all();
        return view('keuangan.index', ['kantin' => $kantin, 'kurir' => $kurir]);
    }

    public function historyKantin($id)
    {
        $data = History::with('kantin')->where('id_kantin', $id)->get();
        return view("keuangan.history-kantin", ['data' => $data, 'id' => $id]);
    }
    public function historyKurir($id)
    {
        $data = History::with('kurir')->where('id_kurir', $id)->get();
        return view("keuangan.history-kurir", ['data' => $data, 'id' => $id]);
    }

    public function procesHistoryKantin($id, $start, $end)
    {
        $idKantin = $id;
        $data = History::with('kantin')->where('id_kantin', $id)->whereBetween('created_at', [$start, $end])->get();
        return view('keuangan.history-kantin-process', compact('data', 'id'));
    }

    public function procesHistoryKurir($id, $start, $end)
    {
        $idKantin = $id;
        $data = History::with('kurir')->where('id_kurir', $id)->whereBetween('created_at', [$start, $end])->get();
        return view('keuangan.history-kurir-process', compact('data', 'id'));
    }


    public function exportHistoryKantin(Request $request)
    {
        $data = json_decode($request->input('data'));
        return Excel::download(new HistoryKantinExport($data), 'kantin.xlsx');
    }


    public function berikanDanaKantin(Request $request)
    {

        if ($request->input('total_saldo') == 0) {
            Alert::error('Peringatan', 'Saldo Tidak Mencukupi');
            return back();
        }
        try {
            //code...
            DB::beginTransaction();
            $kantin = Kantin::find($request->input('id_kantin'));
            if (isset($kantin)) {
                History::create([
                    'id_kantin' => $request->input('id_kantin'),
                    'total_penarikan' => $request->input('total_saldo'),
                    'kode_penarikan' => 'TRK' . rand(10000, 99999)
                ]);
                $kantin->total_saldo = 0;
                $kantin->save();
                DB::commit();
                Alert::success("Sukses", "Berhasil Memberikan Saldo");
                return back();
            }
            return back()->withErrors('Kantin tidak ditemukan');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->withErrors($th->getMessage());
        }

    }

    public function berikanDanaKurir()
    {

    }
}
