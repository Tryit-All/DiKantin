<?php

namespace Database\Seeders;

use App\Models\DetailTransaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataDetailTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array(
                "kode_tr" => "4234232",
                "QTY" => "1",
                "subtotal_bayar" => "10000",
                "kode_menu" => "16",
            ),
            array(
                "kode_tr" => "4234232",
                "QTY" => "2",
                "subtotal_bayar" => "20000",
                "kode_menu" => "20",
            ),
            array(
                "kode_tr" => "8383838",
                "QTY" => "1",
                "subtotal_bayar" => "10000",
                "kode_menu" => "16",
            ),
            array(
                "kode_tr" => "8383838",
                "QTY" => "4",
                "subtotal_bayar" => "40000",
                "kode_menu" => "20",
            ),
        ];

        foreach ($data as $key => $value) {
            DetailTransaksi::create($value);
        }
    }
}
