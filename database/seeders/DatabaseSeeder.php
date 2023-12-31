<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Add Kantin
        $this->call(DataKantinSeeders::class);

        // Add Menu
        $this->call(DataMenuSeeders::class);

        // Add Customer
        $this->call(DataCustomerSeeder::class);

        // Add Role
        $this->call(DataRoleSeeder::class);

        // Add Kurir
        $this->call(DataKurirSeeder::class);

        // Add Transaksi
        // $this->call(DataTransaksiSeeder::class);

        // // Add Detail Transaksi
        // $this->call(DataDetailTransaksiSeeder::class);

        // Add Roles
        $this->call(DataRoles::class);

        // Add Model Has Roles
        $this->call(DataModelHasRoles::class);

        // Add Permissions
        $this->call(DataPermission::class);

        // Add Role Has Permissions
        $this->call(DataRoleHasPermissions::class);

        // Add Customer
        $this->call(DataUserSeeder::class);

    }
}