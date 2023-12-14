<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{


    private $data;
    private $totalPokok;
    private $totalJual;
    private $pendapatan;


    public function __construct($data, $totalPokok, $pendapatan, $totalJual)
    {
        $this->data = $data;
        $this->totalPokok = $totalPokok;
        $this->pendapatan = $pendapatan;
        $this->totalJual = $totalJual;
    }

    public function view(): View
    {
        //r
        // dd($this->data);
        return view("exports.laporan", ['data' => json_decode($this->data), 'totalPokok' => $this->totalPokok, 'pendapatan' => $this->pendapatan, 'totalJual' => $this->totalJual]);
    }
}
