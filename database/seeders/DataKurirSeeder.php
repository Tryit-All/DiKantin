<?php

namespace Database\Seeders;

use App\Models\Kurir;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataKurirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kurir::create(["id_kurir" => "323423", "nama" => "Suparjo", "status" => "0", "telepon" => "089778866889"]);
    }
}
