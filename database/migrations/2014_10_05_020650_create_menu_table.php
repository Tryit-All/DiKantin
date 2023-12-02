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
        Schema::create('menu', function (Blueprint $table) {
            $table->integer('id_menu')->autoIncrement();
            $table->string('nama', 100);
            $table->integer('harga');
            $table->string('foto', 255);
            $table->enum('status_stok', ['ada', 'tidak ada']);
            $table->enum('kategori', ['makanan', 'minuman']);
            $table->integer('id_kantin');
            $table->double('diskon', 8, 2)->nullable();
            $table->foreign('id_kantin')->references('id_kantin')->on('kantin')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};