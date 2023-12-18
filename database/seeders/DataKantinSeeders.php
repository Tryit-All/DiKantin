<?php

namespace Database\Seeders;

use App\Models\Kantin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataKantinSeeders extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            array(
                "id_kantin" => 1,
                "nama" => "kantin 1",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            array(
                "id_kantin" => 2,
                "nama" => "kantin 2",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            array(
                "id_kantin" => 3,
                "nama" => "kantin 3",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            array(
                "id_kantin" => 4,
                "nama" => "kantin 4",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            array(
                "id_kantin" => 5,
                "nama" => "kantin 5",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            array(
                "id_kantin" => 6,
                "nama" => "kantin 6",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            array(
                "id_kantin" => 7,
                "nama" => "kantin 7",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            array(
                "id_kantin" => 8,
                "nama" => "kantin 8",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            array(
                "id_kantin" => 9,
                "nama" => "kantin 9",
                "status" => 1,
                "created_at" => "2023-10-08 05:17:55",
                "updated_at" => "2023-10-08 12:46:28",
            ),
            // Tambahkan data lainnya sesuai dengan contoh di atas
        ];

        foreach ($data as $key => $value) {
            Kantin::create($value);
        }
    }
}