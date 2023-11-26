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
            $table->string('kode_tr', 9)->primary();
            $table->enum('status_konfirm', ['1', '2', '3']);
            $table->enum('status_pesanan', ['1', '2', '3']);
            $table->dateTime('tanggal');
            $table->string('id_customer', 9);
            $table->string('id_kurir', 9)->nullable(true);
            $table->integer('id_kasir')->nullable();
            $table->integer('total_bayar');
            $table->integer('total_harga');
            $table->integer('kembalian');
            $table->enum('status_pengiriman', ['proses', 'kirim', 'terima']);
            $table->string('bukti_pengiriman', 255)->nullable(true);
            $table->integer('no_meja');
            $table->enum('model_pembayaran', ['cash', 'gopay', 'qris', 'polijepay', 'tranfer bank']);
            $table->foreign('id_customer')->references('id_customer')->on('customer')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_kurir')->references('id_kurir')->on('kurir')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamp('expired_at')->nullable(true);
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