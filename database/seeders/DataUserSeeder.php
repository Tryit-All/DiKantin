<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DataUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::create(["id_customer" => "Cust d8a16ef5-13fc-409d-9015-d0e317d275c5", "nama" => "fathur", "no_telepon" => "32e233dw3", "email_verified" => "1", "kode_verified" => null, "alamat" => "dadwadw", "email" => "fathurrahman.dk@gmail.com", "password" => Hash::make('rahasia'), "foto" => null,]);
    }
}