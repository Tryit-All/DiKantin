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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->string('kode_tr', 9);
            $table->integer('QTY');
            $table->integer('subtotal_bayar');
            $table->integer('kode_menu');
            $table->enum('status_konfirm', ['menunggu', 'memasak', 'selesai'])->nullable(true);
            $table->foreign('kode_tr')->references('kode_tr')->on('transaksi')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('kode_menu')->references('id_menu')->on('menu')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaski');
    }
};