<?php

namespace Database\Seeders;

use App\Models\Kurir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataKurirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array("id_kurir" => "23189", "email" => "koryanto@gmail.com", "password" => Hash::make('123456'), "nama" => "Koryanto", "status" => "0", "token" => null, "token_fcm" => null, "telepon" => "08944775532", "foto" => null, "created_at" => null, "updated_at" => null),
            array("id_kurir" => "3219", "email" => "DwiK@gmail.com", "password" => Hash::make('123456'), "nama" => "Dwi ", "status" => "1", "token" => null, "token_fcm" => null, "telepon" => "089778866889", "foto" => null, "created_at" => "2023-11-15 05:34:33", "updated_at" => "2023-11-15 05:34:33"),
            array("id_kurir" => "323423", "email" => "fathur@gmail.com", "password" => Hash::make('123456'), "nama" => "Suparjo", "status" => "1", "token" => null, "token_fcm" => null, "telepon" => "089778866889", "foto" => null, "created_at" => "2023-11-15 05:34:33", "updated_at" => "2023-11-15 05:34:33"),
            array("id_kurir" => "7884", "email" => "fathurrahmandk02@gmail.com", "password" => Hash::make('123456'), "nama" => "rahman", "status" => "1", "token" => null, "token_fcm" => null, "telepon" => "08944775532", "foto" => null, "created_at" => null, "updated_at" => null)
            // Tambahkan data lainnya sesuai dengan contoh di atas
        ];

        foreach ($data as $key => $value) {
            Kurir::create($value);
        }
        // Kurir::create(["id_kurir" => "323423", "email" => "fathurrahmandk02@gmail.com", "password" => Hash::make('rahasia'), "nama" => "Suparjo", "status" => "0", "telepon" => "089778866889", "foto" => null]);
    }
}
