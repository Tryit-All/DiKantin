<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class HistoryKurirExport implements FromView
{

    private $data;

    public function __construct($data) {
        $this->data =  $data;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view() : View 
    {
        //
        $data = json_decode($this->data);
        
        return view('exports.history-kurir' , ['data' => $data]);
    }
}
