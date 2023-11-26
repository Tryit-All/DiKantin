<?php

namespace Database\Seeders;

use App\Models\Permissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPermission extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array("id" => "1", "name" => "customer-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:09", "updated_at" => "2023-05-19 19:48:09"),
            array("id" => "2", "name" => "customer-create", "guard_name" => "web", "created_at" => "2023-05-19 19:48:09", "updated_at" => "2023-05-19 19:48:09"),
            array("id" => "3", "name" => "customer-edit", "guard_name" => "web", "created_at" => "2023-05-19 19:48:09", "updated_at" => "2023-05-19 19:48:09"),
            array("id" => "4", "name" => "customer-delete", "guard_name" => "web", "created_at" => "2023-05-19 19:48:09", "updated_at" => "2023-05-19 19:48:09"),
            array("id" => "5", "name" => "menu-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:09", "updated_at" => "2023-05-19 19:48:09"),
            array("id" => "6", "name" => "menu-create", "guard_name" => "web", "created_at" => "2023-05-19 19:48:09", "updated_at" => "2023-05-19 19:48:09"),
            array("id" => "7", "name" => "menu-edit", "guard_name" => "web", "created_at" => "2023-05-19 19:48:09", "updated_at" => "2023-05-19 19:48:09"),
            array("id" => "8", "name" => "menu-delete", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "9", "name" => "order-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "10", "name" => "orderdetailpenjualan-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "11", "name" => "orderdetailpenjualan-edit", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "12", "name" => "orderdetailpenjualan-delete", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "13", "name" => "orderpenjualan-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "14", "name" => "orderpenjualan-edit", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "15", "name" => "orderpenjualan-delete", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "16", "name" => "role-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "17", "name" => "role-create", "guard_name" => "web", "created_at" => "2023-05-19 19:48:10", "updated_at" => "2023-05-19 19:48:10"),
            array("id" => "18", "name" => "role-edit", "guard_name" => "web", "created_at" => "2023-05-19 19:48:11", "updated_at" => "2023-05-19 19:48:11"),
            array("id" => "19", "name" => "role-delete", "guard_name" => "web", "created_at" => "2023-05-19 19:48:11", "updated_at" => "2023-05-19 19:48:11"),
            array("id" => "20", "name" => "successorder-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:11", "updated_at" => "2023-05-19 19:48:11"),
            array("id" => "21", "name" => "user-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:11", "updated_at" => "2023-05-19 19:48:11"),
            array("id" => "22", "name" => "user-create", "guard_name" => "web", "created_at" => "2023-05-19 19:48:11", "updated_at" => "2023-05-19 19:48:11"),
            array("id" => "23", "name" => "user-edit", "guard_name" => "web", "created_at" => "2023-05-19 19:48:11", "updated_at" => "2023-05-19 19:48:11"),
            array("id" => "24", "name" => "user-delete", "guard_name" => "web", "created_at" => "2023-05-19 19:48:11", "updated_at" => "2023-05-19 19:48:11"),
            array("id" => "25", "name" => "pos-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12"),
            array("id" => "26", "name" => "laporan-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12"),
            array("id" => "27", "name" => "laporan-cetak", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12"),
            array("id" => "28", "name" => "rekapitulasi-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12"),
            array("id" => "29", "name" => "cek-Rekapitulasi", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12"),
            array("id" => "30", "name" => "cetak-Rekapitulasi", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12"),
            array("id" => "31", "name" => "Transaksi-list", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12"),
            array("id" => "32", "name" => "Transaksi-detail", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12"),
            array("id" => "33", "name" => "Transaksi-hapus", "guard_name" => "web", "created_at" => "2023-05-19 19:48:12", "updated_at" => "2023-05-19 19:48:12")
        ];

        foreach ($data as $key => $value) {
            Permissions::create($value);
        }
    }
}
