<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataMenuSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array("id_menu" => "9", "nama" => "Soto Ayam", "harga_pokok" => "4000", "harga" => "5000", "foto" => "menu\/koQRkMxm5x4SB2JAqhDVg4rLgAES0wg00Ih0uKgi.png", "status_stok" => "tidak ada", "kategori" => "minuman", "id_kantin" => "6", "diskon" => null, "created_at" => "2023-04-14 01:43:12", "updated_at" => "2023-04-30 05:56:44"),
            array("id_menu" => "10", "nama" => "Gado-gado", "harga_pokok" => "4000", "harga" => "5000", "foto" => "menu\/MU1qcs3g6pNoNfhZmhspeOQEylRXU4Nl3Ki8DNJu.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "3", "diskon" => null, "created_at" => "2023-04-14 01:45:50", "updated_at" => "2023-05-02 06:32:03"),
            array("id_menu" => "11", "nama" => "Es Teh", "harga_pokok" => "2500", "harga" => "3000", "foto" => "menu\/A6x5TjzFfKJ39oOyDJOeCTuvffL56HD0KmWn4ipd.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "4", "diskon" => null, "created_at" => "2023-04-14 02:39:20", "updated_at" => "2023-05-03 04:12:04"),
            array("id_menu" => "13", "nama" => "Aqua", "harga_pokok" => "2500", "harga" => "3000", "foto" => "menu\/rjwJkLd1Zo5RvWutZWqFuiEKF8MjklFkX1M0gZCC.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "1", "diskon" => null, "created_at" => "2023-04-14 02:40:19", "updated_at" => "2023-05-08 07:29:57"),
            array("id_menu" => "15", "nama" => "Nasi Goreng", "harga_pokok" => "7000", "harga" => "8000", "foto" => "menu\/lJu3UQn5Urh4f6yIvB1isfLjfuah1GaFGXRQHR8R.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "1", "diskon" => null, "created_at" => "2023-04-14 02:55:36", "updated_at" => "2023-05-08 07:30:06"),
            array("id_menu" => "16", "nama" => "Ayam Bakar", "harga_pokok" => "11000", "harga" => "12000", "foto" => "menu\/n9hWAwaqoFiZjnNMcDZlaaiAiH6aC2Wb5fEfi6cJ.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "1", "diskon" => null, "created_at" => "2023-04-14 02:57:50", "updated_at" => "2023-05-03 06:23:36"),
            array("id_menu" => "17", "nama" => "Es Jeruk", "harga_pokok" => "2500", "harga" => "3000", "foto" => "menu\/HvUL2FL75oZyzqvSqQMIqwy0sz3z0lZPG81YSNyM.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "1", "diskon" => null, "created_at" => "2023-04-14 03:02:51", "updated_at" => "2023-05-02 03:17:33"),
            array("id_menu" => "18", "nama" => "Lalapan", "harga_pokok" => "6000", "harga" => "7000", "foto" => "menu\/WDNGW8EotGSqjmYuT8wrm5U4tmgXTVJWi4GmYfFo.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "3", "diskon" => null, "created_at" => "2023-04-14 03:04:39", "updated_at" => "2023-05-02 01:00:01"),
            array("id_menu" => "20", "nama" => "Ayam Geprek", "harga_pokok" => "9000", "harga" => "10000", "foto" => "menu\/jSU3bn6yUBulPNfClPWfA0HFZNU0NheKTfyMdjiS.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "2", "diskon" => null, "created_at" => "2023-04-18 16:58:10", "updated_at" => "2023-05-09 02:53:23"),
            array("id_menu" => "21", "nama" => "Nasi Goreng", "harga_pokok" => "9000", "harga" => "10000", "foto" => "menu\/qbol6ixrV5LHNtq5eYJWed0zNBtdipM7MeO4wgzr.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "3", "diskon" => null, "created_at" => "2023-04-19 23:14:53", "updated_at" => "2023-05-02 04:12:15"),
            array("id_menu" => "22", "nama" => "Es Teh", "harga_pokok" => "2500", "harga" => "3000", "foto" => "menu\/J3j0Y84oUzwS4cxJmC9kcyLGnBexMb3rl6iNoEUy.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "2", "diskon" => null, "created_at" => "2023-04-25 03:12:25", "updated_at" => "2023-05-08 16:23:11"),
            array("id_menu" => "23", "nama" => "Soda Gembira", "harga_pokok" => "6500", "harga" => "7000", "foto" => "menu\/WmNsyLZ34zLzyEm1NPyVcH1yMvpQVQgAqoA0Mdk9.png", "status_stok" => "tidak ada", "kategori" => "minuman", "id_kantin" => "5", "diskon" => null, "created_at" => "2023-04-25 03:13:08", "updated_at" => "2023-04-25 03:13:08"),
            array("id_menu" => "24", "nama" => "Bakso", "harga_pokok" => "7000", "harga" => "8000", "foto" => "menu\/UBb0h7fG9ZiebLr7dSKJHzZ4JC5g5Xn3Gd3wujn7.png", "status_stok" => "tidak ada", "kategori" => "makanan", "id_kantin" => "5", "diskon" => null, "created_at" => "2023-04-25 03:15:48", "updated_at" => "2023-04-25 03:15:48"),
            array("id_menu" => "25", "nama" => "Es Jeruk", "harga_pokok" => "2500", "harga" => "3000", "foto" => "menu\/jesdLPh0JG1WcTk4O2xSSsoLJQaRSVejmRy9q1ha.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "9", "diskon" => null, "created_at" => "2023-05-02 03:41:47", "updated_at" => "2023-05-02 03:41:47"),
            array("id_menu" => "26", "nama" => "Kopi Hitam", "harga_pokok" => "2500", "harga" => "3000", "foto" => "menu\/nmMkYhJ1qwOs5zEoEqT6W8ab0fyg2Fm7p0O9Muxp.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "3", "diskon" => null, "created_at" => "2023-05-03 02:59:04", "updated_at" => "2023-05-03 06:19:34"),
            array("id_menu" => "27", "nama" => "Nutrisari", "harga_pokok" => "3500", "harga" => "4000", "foto" => "menu\/5wibhg8oEVUrxoFdKUD0SZzRXdkSmsrPASDyZ8K1.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "4", "diskon" => null, "created_at" => "2023-05-03 03:00:30", "updated_at" => "2023-05-03 03:00:30"),
            array("id_menu" => "28", "nama" => "Kopi Susu", "harga_pokok" => "4500", "harga" => "5000", "foto" => "menu\/AaWqJX8m1nhgb253PW9biff0YGdkX3AmY4zqVfXr.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "9", "diskon" => null, "created_at" => "2023-05-03 03:01:31", "updated_at" => "2023-05-03 03:01:31"),
            array("id_menu" => "32", "nama" => "Seblak", "harga_pokok" => "7000", "harga" => "8000", "foto" => "menu\/s2StjfY6JQNGfLDq3zO4yujixTNHDalYJuGMutDR.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "4", "diskon" => null, "created_at" => "2023-05-03 04:06:43", "updated_at" => "2023-05-03 04:06:43"),
            array("id_menu" => "33", "nama" => "Teh Hangat", "harga_pokok" => "2500", "harga" => "3000", "foto" => "menu\/WbNsQ08nNi8zYRVpXougeZSeJOpVQHIpKGGD2Hnt.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "6", "diskon" => null, "created_at" => "2023-05-03 04:10:59", "updated_at" => "2023-05-03 04:11:22"),
            array("id_menu" => "35", "nama" => "Tahu Lontong", "harga_pokok" => "9000", "harga" => "10000", "foto" => "menu\/cmXBQx5bSTgmkjfcUbGSwUhqY10YVAkCeI79n82F.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "2", "diskon" => null, "created_at" => "2023-05-03 04:16:44", "updated_at" => "2023-05-08 16:22:25"),
            array("id_menu" => "36", "nama" => "Bakso", "harga_pokok" => "7000", "harga" => "8000", "foto" => "menu\/NzCzUBoyAT3CLrmDgbYVd3BZFnIuAwS8hE3U1ON5.png", "status_stok" => "ada", "kategori" => "makanan", "id_kantin" => "4", "diskon" => null, "created_at" => "2023-05-03 04:17:58", "updated_at" => "2023-05-08 06:31:46"),
            array("id_menu" => "38", "nama" => "Es Buah", "harga_pokok" => "7500", "harga" => "8000", "foto" => "menu\/AXOdRYablFOXTWR7YWiC0QHhtiYdqqFYTfO7ygaK.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "3", "diskon" => null, "created_at" => "2023-05-03 04:22:55", "updated_at" => "2023-05-03 04:22:55"),
            array("id_menu" => "39", "nama" => "Air", "harga_pokok" => "500", "harga" => "1000", "foto" => "menu\/X5pPfbxK7H6kEo71tFR8ExXXXRtTHuhXWKQZvmS4.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "5", "diskon" => null, "created_at" => "2023-05-03 04:24:46", "updated_at" => "2023-05-03 04:24:46"),
            array("id_menu" => "40", "nama" => "Jus Alpukat", "harga_pokok" => "7500", "harga" => "8000", "foto" => "menu\/2XhSs0mr8VNLBXHlO28O9uoF1XsTgAd7XHAOShZK.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "5", "diskon" => null, "created_at" => "2023-05-03 04:26:17", "updated_at" => "2023-05-03 04:26:17"),
            array("id_menu" => "41", "nama" => "Jus Mangga", "harga_pokok" => "5500", "harga" => "6000", "foto" => "menu\/VCHoecWUCoAWEdwabyzKKVPoCnGGXo2R7zp7QQjK.png", "status_stok" => "ada", "kategori" => "minuman", "id_kantin" => "5", "diskon" => null, "created_at" => "2023-05-03 06:12:33", "updated_at" => "2023-05-03 06:12:33")
        ];

        foreach ($data as $key => $value) {
            Menu::create($value);
        }
    }
}