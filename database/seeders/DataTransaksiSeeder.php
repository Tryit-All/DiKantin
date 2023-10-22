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
                "kode_tr" => "4234232",
                "status_konfirm" => "2",
                "status_pesanan" => "2",
                "tanggal" => "2023-10-21 09:32:59",
                "id_customer" => "Cust d8a16ef5-13fc-409d-9015-d0e317d275c5",
                "id_kurir" => "323423",
                "total_bayar" => "50000",
                "total_harga" => "30000",
                "kembalian" => "20000",
                "status_pengiriman" => "terima",
                "bukti_pengiriman" => "fefawsdfasd",
                "model_pembayaran" => "cash"
            ),
            array(
                "kode_tr" => "8383838",
                "status_konfirm" => "2",
                "status_pesanan" => "2",
                "tanggal" => "2023-10-21 09:32:59",
                "id_customer" => "Cust d8a16ef5-13fc-409d-9015-d0e317d275c5",
                "id_kurir" => "323423",
                "total_bayar" => "100000",
                "total_harga" => "50000",
                "kembalian" => "50000",
                "status_pengiriman" => "terima",
                "bukti_pengiriman" => "fefawsdfasd",
                "model_pembayaran" => "cash"
            ),
            // Tambahkan data lainnya sesuai dengan contoh di atas
        ];

        foreach ($data as $key => $value) {
            Transaksi::create($value);
        }
    }
}


