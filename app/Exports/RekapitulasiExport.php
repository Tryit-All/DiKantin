<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RekapitulasiExport implements FromView, WithEvents
{

    private $data;
    private $totalPokok;
    private $pendapatan;
    public function __construct($data, $totalPokok, $pendapatan)
    {
        $this->data = $data;
        $this->totalPokok = $totalPokok;
        $this->pendapatan = $pendapatan;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        //
        return view("exports.rekapitulasi", ['data' => $this->data, 'totalPokok' => $this->totalPokok, 'pendapatan' => $this->pendapatan]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Get the highest row and column index with data
                $highestRow = $event->sheet->getHighestRow();
                $highestColumn = $event->sheet->getHighestColumn();

                // Set borders for the entire table
                $event->sheet->getDelegate()->getStyle('A1:' . $highestColumn . $highestRow)->getBorders()->getAllBorders()->setBorderStyle('thin');
                // Set borders for the header row
                $columnWidth = 20;
                for ($col = 'A'; $col <= $highestColumn; $col++) {
                    $event->sheet->getDelegate()->getColumnDimension($col)->setWidth($columnWidth);
                }
            },
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();

        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => 'end'],
            ],
            $highestRow - 2 => [
                'alignment' => ['horizontal' => 'end'],
            ],
            $highestRow - 1 => [
                'alignment' => ['horizontal' => 'end'],
            ],
            $highestRow => [
                'alignment' => ['horizontal' => 'end', 'vertical' => 'end'],
                'font' => ['bold' => true],
            ],
        ];
    }
}
