<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\RekapitulasiExport;
use App\Http\Middleware\AdminDLLMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\DwpMiddleware;
use App\Http\Middleware\KasirMiddleware;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Carbon\Carbon;

use Maatwebsite\Excel\Excel;
use Maatwebsite\Excel\Facades\Excel as FacadesExcel;
class LaporanKurirController extends Controller
{
 
    function __construct()
    {
        $this->middleware([AdminDLLMiddleware::class]);
    }
    public function index()  {
        $ongkirByCourier = Transaksi::selectRaw('id_kurir, SUM(total_biaya_kurir) as total_ongkir')
    // ->whereDate('created_at',now()->toDateString())
    ->where('status_pengiriman','terima')
    ->whereNotNull('id_kurir')
    ->groupBy('id_kurir')
    ->with('Kurir:id_kurir,nama') // Memuat data kurir dengan kolom yang ingin ditampilkan (misalnya id dan nama)
    ->get();

    return view(
        'dashboard.kurir.Kurir',
        [
            'ongkirByCourier' => $ongkirByCourier,
           
        ]
    );
        
    }
}
