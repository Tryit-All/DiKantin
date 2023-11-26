<?php

namespace Database\Seeders;

use App\Models\ModelHasRoles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataModelHasRoles extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            array("role_id" => "1", "model_type" => "App\\Models\\User", "model_id" => "1"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "7"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "8"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "9"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "10"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "11"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "12"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "13"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "14"),
            array("role_id" => "3", "model_type" => "App\\Models\\User", "model_id" => "15"),
            array("role_id" => "4", "model_type" => "App\\Models\\User", "model_id" => "16")
            // Tambahkan data lainnya sesuai dengan contoh di atas
        ];

        foreach ($data as $key => $value) {
            ModelHasRoles::create($value);
        }
    }
}
