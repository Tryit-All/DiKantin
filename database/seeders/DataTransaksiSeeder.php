<?php

namespace Database\Seeders;

use App\Models\Transaksi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataTransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array(
                "kode_tr" => "TRDKN9272",
                "status_konfirm" => "1",
                "status_pesanan" => "1",
                "tanggal" => "2023-10-21 09:32:59",
                "id_customer" => "CUST98273",
                "id_kurir" => "323423",
                "total_bayar" => "50000",
                "total_harga" => "30000",
                "kembalian" => "20000",
                "status_pengiriman" => "proses",
                "bukti_pengiriman" => "fefawsdfasd",
                "model_pembayaran" => "cash",
                "created_at" => "2023-11-08 05:17:55",
                "updated_at" => "2023-11-08 12:46:28",
            ),
            array(
                "kode_tr" => "TRDKN9928",
                "status_konfirm" => "1",
                "status_pesanan" => "1",
                "tanggal" => "2023-10-21 09:32:59",
                "id_customer" => "CUST98273",
                "id_kurir" => "323423",
                "total_bayar" => "100000",
                "total_harga" => "50000",
                "kembalian" => "50000",
                "status_pengiriman" => "proses",
                "bukti_pengiriman" => "fefawsdfasd",
                "model_pembayaran" => "cash",
                "created_at" => "2023-11-09 05:17:55",
                "updated_at" => "2023-11-09 12:46:28",
            ),

            array(
                "kode_tr" => "TRDKN8882",
                "status_konfirm" => "1",
                "status_pesanan" => "1",
                "tanggal" => "2023-10-21 09:32:59",
                "id_customer" => "CUST98273",
                "id_kurir" => "323423",
                "total_bayar" => "100000",
                "total_harga" => "50000",
                "kembalian" => "50000",
                "status_pengiriman" => "proses",
                "bukti_pengiriman" => "fefawsdfasd",
                "model_pembayaran" => "cash",
                "created_at" => "2023-11-10 05:17:55",
                "updated_at" => "2023-11-10 12:46:28",
            ),
            // Tambahkan data lainnya sesuai dengan contoh di atas
        ];

        foreach ($data as $key => $value) {
            Transaksi::create($value);
        }
    }
}


