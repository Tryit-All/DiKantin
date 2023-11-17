<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array("id_role" => "1", "nama" => "Admin"),
            array("id_role" => "2", "nama" => "Kasir"),
            array("id_role" => "3", "nama" => "Kantin")
            // Tambahkan data lainnya sesuai dengan contoh di atas
        ];

        foreach ($data as $key => $value) {
            Role::create($value);
        }
    }
}
