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
                "subtotal_bayar" => "12000",
                "subtotal_hargapokok" => "11000",
                "kode_menu" => "16",
                "status_konfirm" => "menunggu",
                "created_at" => "2023-11-08 05:17:55",
                "updated_at" => "2023-11-08 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN9272",
                "QTY" => "2",
                "subtotal_bayar" => "20000",
                "subtotal_hargapokok" => "18000",
                "kode_menu" => "20",
                "status_konfirm" => "menunggu",
                "created_at" => "2023-11-08 05:17:55",
                "updated_at" => "2023-11-08 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN9928",
                "QTY" => "1",
                "subtotal_bayar" => "12000",
                "subtotal_hargapokok" => "11000",
                "kode_menu" => "16",
                "status_konfirm" => "menunggu",
                "created_at" => "2023-11-09 05:17:55",
                "updated_at" => "2023-11-09 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN9928",
                "QTY" => "4",
                "subtotal_bayar" => "40000",
                "subtotal_hargapokok" => "36000",
                "kode_menu" => "20",
                "status_konfirm" => "menunggu",
                "created_at" => "2023-11-09 05:17:55",
                "updated_at" => "2023-11-09 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN8882",
                "QTY" => "1",
                "subtotal_bayar" => "12000",
                "subtotal_hargapokok" => "11000",
                "kode_menu" => "16",
                "status_konfirm" => "menunggu",
                "created_at" => "2023-11-10 05:17:55",
                "updated_at" => "2023-11-10 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN2708",
                "QTY" => "4",
                "subtotal_bayar" => "40000",
                "subtotal_hargapokok" => "36000",
                "kode_menu" => "20",
                "status_konfirm" => "menunggu",
                "created_at" => "2023-11-10 05:17:55",
                "updated_at" => "2023-11-10 12:46:28",
            ),
            array("kode_tr" => "TRDKN9405", "QTY" => "1",
             "subtotal_bayar" => "5000", 
             "subtotal_hargapokok" => "4000", 

            "kode_menu" => "10", "status_konfirm" => "menunggu", "created_at" => "2023-11-26 13:40:37", "updated_at" => "2023-11-26 17:04:43"),
            array("kode_tr" => "TRDKN2708", "QTY" => "1", 
            "subtotal_bayar" => "3000", 
            "subtotal_hargapokok" => "2500", 
            "kode_menu" => "13", "status_konfirm" => "menunggu", "created_at" => "2023-11-26 13:40:50", "updated_at" => "2023-11-26 17:04:43"),
            array("kode_tr" => "TRDKN2708", "QTY" => "1", 
            "subtotal_bayar" => "8000",
            "subtotal_hargapokok" => "7000",
             "kode_menu" => "15", "status_konfirm" => "menunggu", "created_at" => "2023-11-26 13:40:50", "updated_at" => "2023-11-26 17:04:43"),
            array("kode_tr" => "TRDKN5138", "QTY" => "1", 
            "subtotal_bayar" => "5000", 
            "subtotal_hargapokok" => "4000", 
            "kode_menu" => "10", "status_konfirm" => "menunggu", "created_at" => "2023-11-26 13:49:41", "updated_at" => "2023-11-26 17:04:43"),
            array("kode_tr" => "TRDKN5138", "QTY" => "1", 
            "subtotal_bayar" => "3000",
            "subtotal_hargapokok" => "2500",
             "kode_menu" => "11", "status_konfirm" => "menunggu", "created_at" => "2023-11-26 13:49:41", "updated_at" => "2023-11-26 17:04:43")
        ];

        foreach ($data as $key => $value) {
            DetailTransaksi::create($value);
        }
    }
}
