<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class LaporanExport implements FromView
{

    public function view(): View
    {
        //r
        return view("exports.laporan");
    }
}
