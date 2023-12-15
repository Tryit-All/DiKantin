<?php

namespace Database\Seeders;

use App\Models\User;
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
        $data = [
            array("username" => "Admin DiKantin", "email" => "admin@gmail.com", "password" => Hash::make('123456'), "id_kantin" => null, "id_role" => "1", "foto" => "profile\/AihU4LhLlofnR7s6QYFMDMcInBMEsqYwhHDIF7YL.jpg", "remember_token" => null, "created_at" => "2023-05-19 19:48:39", "updated_at" => "2023-05-28 13:01:04"),
            array("username" => "kantin 1", "email" => "kantin1@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 1, "id_role" => "3", "foto" => "profile\/TY4JSoRJW0dijrHZp8w0A7d9gXGOPsezLWXzpUrY.jpg", "remember_token" => null, "created_at" => "2023-06-07 08:54:51", "updated_at" => "2023-08-12 11:21:54"),
            array("username" => "kantin 2", "email" => "kantin2@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 2, "id_role" => "3", "foto" => "profile\/1kre0O8B6ygpXFGbYqcJ1wEJX4Ro5BKJpcNxm1dn.jpg", "remember_token" => null, "created_at" => "2023-06-07 08:57:29", "updated_at" => "2023-06-23 11:03:18"),
            array("username" => "kantin 3", "email" => "kantin3@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 3, "id_role" => "3", "foto" => "profile\/IMyXH2ZZmtKFCwHBwtHrdhELUm79lmuJWafqc0uO.png", "remember_token" => null, "created_at" => "2023-06-07 08:58:27", "updated_at" => "2023-06-07 08:58:27"),
            array("username" => "kantin 4", "email" => "kantin4@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 4, "id_role" => "3", "foto" => "profile\/FhDgmNKmnwH0jA6REvOpeRkwvNIW6GsmZsvDb9Oc.png", "remember_token" => null, "created_at" => "2023-06-07 08:59:14", "updated_at" => "2023-06-07 08:59:14"),
            array("username" => "kantin 5", "email" => "kantin5@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 5, "id_role" => "3", "foto" => "profile\/atlEekB9MJHEwiXz6hhjipSR6YzQ16cTQbKoFpoa.png", "remember_token" => null, "created_at" => "2023-06-07 09:00:09", "updated_at" => "2023-06-07 09:00:09"),
            array("username" => "kantin 6", "email" => "kantin6@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 6, "id_role" => "3", "foto" => "profile\/04zCAuy2Vc4Uhe7KLCwttj88YgCp55W570tJtWCn.png", "remember_token" => null, "created_at" => "2023-06-07 09:01:25", "updated_at" => "2023-06-07 09:01:25"),
            array("username" => "kantin 7", "email" => "kantin7@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 7, "id_role" => "3", "foto" => "profile\/bckBfrV8wIoxjbssxx3MTxEdY279cvQeZdAnM3ij.png", "remember_token" => null, "created_at" => "2023-06-07 09:02:19", "updated_at" => "2023-06-07 09:02:19"),
            array("username" => "kantin 8", "email" => "kantin8@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 8, "id_role" => "3", "foto" => "profile\/dVHwvW3DvSoglyjo3Zm1i3vkgDtGj5Qk85jkPu7q.png", "remember_token" => null, "created_at" => "2023-06-07 09:03:11", "updated_at" => "2023-06-07 09:03:11"),
            array("username" => "kantin 9", "email" => "kantin9@gmail.com", "password" => Hash::make('123456'), "id_kantin" => 9, "id_role" => "3", "foto" => "profile\/ejjACKlijl7dr11f4YZNs0QmBFw32fn2OmoLBilh.png", "remember_token" => null, "created_at" => "2023-06-07 09:04:01", "updated_at" => "2023-06-07 09:04:01"),
            array("username" => "kasir", "email" => "kasir@gmail.com", "password" => Hash::make('123456'), "id_kantin" => null, "id_role" => "4", "foto" => "profile\/ejjACKlijl7dr11f4YZNs0QmBFw32fn2OmoLBilh.png", "remember_token" => null, "created_at" => "2023-06-23 09:14:45", "updated_at" => "2023-06-23 09:14:45"),
            array("username" => "dpwp", "email" => "dwp@gmail.com", "password" => Hash::make('123456'), "id_kantin" => null, "id_role" => "5", "foto" => "profile\/ejjACKlijl7dr11f4YZNs0QmBFw32fn2OmoLBilh.png", "remember_token" => null, "created_at" => "2023-06-23 09:14:45", "updated_at" => "2023-06-23 09:14:45"),
            array("username" => "tefa", "email" => "tefa@gmail.com", "password" => Hash::make('123456'), "id_kantin" => null, "id_role" => "2", "foto" => "profile\/ejjACKlijl7dr11f4YZNs0QmBFw32fn2OmoLBilh.png", "remember_token" => null, "created_at" => "2023-06-23 09:14:45", "updated_at" => "2023-06-23 09:14:45"),
            // Tambahkan data lainnya sesuai dengan contoh di atas
        ];

        foreach ($data as $key => $value) {
            User::create($value);
        }
    }
}
