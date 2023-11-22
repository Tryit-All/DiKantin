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
                "kode_tr" => "TRDKN9272",
                "QTY" => "1",
                "subtotal_bayar" => "10000",
                "kode_menu" => "16",
                "created_at" => "2023-11-08 05:17:55",
                "updated_at" => "2023-11-08 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN9272",
                "QTY" => "2",
                "subtotal_bayar" => "20000",
                "kode_menu" => "20",
                "created_at" => "2023-11-08 05:17:55",
                "updated_at" => "2023-11-08 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN9928",
                "QTY" => "1",
                "subtotal_bayar" => "10000",
                "kode_menu" => "16",
                "created_at" => "2023-11-09 05:17:55",
                "updated_at" => "2023-11-09 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN9928",
                "QTY" => "4",
                "subtotal_bayar" => "40000",
                "kode_menu" => "20",
                "created_at" => "2023-11-09 05:17:55",
                "updated_at" => "2023-11-09 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN8882",
                "QTY" => "1",
                "subtotal_bayar" => "10000",
                "kode_menu" => "16",
                "created_at" => "2023-11-10 05:17:55",
                "updated_at" => "2023-11-10 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN8882",
                "QTY" => "4",
                "subtotal_bayar" => "40000",
                "kode_menu" => "20",
                "created_at" => "2023-11-10 05:17:55",
                "updated_at" => "2023-11-10 12:46:28",
            ),
        ];

        foreach ($data as $key => $value) {
            DetailTransaksi::create($value);
        }
    }
}
