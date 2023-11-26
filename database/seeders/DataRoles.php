<?php

namespace Database\Seeders;

use App\Models\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array("id" => "1", "name" => "Admin", "guard_name" => "web", "created_at" => "2023-05-19 19:48:40", "updated_at" => "2023-05-19 19:48:40"),
            array("id" => "2", "name" => "Tefa", "guard_name" => "web", "created_at" => "2023-05-19 19:51:19", "updated_at" => "2023-05-19 19:51:19"),
            array("id" => "3", "name" => "Kantin", "guard_name" => "web", "created_at" => "2023-05-19 19:51:43", "updated_at" => "2023-05-19 19:51:43"),
            array("id" => "4", "name" => "Kasir", "guard_name" => "web", "created_at" => "2023-05-19 19:52:29", "updated_at" => "2023-05-19 19:52:29"),
            array("id" => "5", "name" => "Dharmawanita", "guard_name" => "web", "created_at" => "2023-05-19 19:52:55", "updated_at" => "2023-05-19 19:52:55")
        ];

        foreach ($data as $key => $value) {
            Roles::create($value);
        }

    }
}
