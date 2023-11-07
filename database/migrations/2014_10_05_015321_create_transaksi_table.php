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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->integer('kode_tr')->primary();
            $table->enum('status_konfirm', ['1', '2']);
            $table->enum('status_pesanan', ['1', '2']);
            $table->dateTime('tanggal');
            $table->string('id_customer', 255);
            $table->integer('id_kurir');
            $table->integer('total_bayar');
            $table->integer('total_harga');
            $table->integer('kembalian');
            $table->enum('status_pengiriman', ['proses', 'kirim', 'terima']);
            $table->string('bukti_pengiriman', 255)->nullable(true);
            $table->enum('model_pembayaran', ['cash', 'gopay', 'qris', 'polijepay', 'tranfer bank']);
            $table->foreign('id_customer')->references('id_customer')->on('customer')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_kurir')->references('id_kurir')->on('kurir')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};