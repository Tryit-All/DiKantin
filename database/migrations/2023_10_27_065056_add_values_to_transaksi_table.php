<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Schema::table('transaksi', function (Blueprint $table) {
        //     $table->enum('status_konfirm', ['1', '2', '3', '4', '5', '6', '7', '8', '9'])->change();
        //     $table->enum('status_pesanan', ['1', '2', '3'])->change();
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            //
        });
    }
};
