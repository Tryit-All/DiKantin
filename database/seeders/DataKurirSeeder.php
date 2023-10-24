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
        Kurir::create(["id_kurir" => "323423", "email" => "fathurrahmandk02@gmail.com", "password" => Hash::make('rahasia'), "nama" => "Suparjo", "status" => "0", "telepon" => "089778866889", "foto" => null]);
    }
}
