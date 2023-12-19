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
        Schema::create('history_penarikan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('total_penarikan');
            $table->string('kode_penarikan');
            $table->integer('id_kantin')->nullable();
            $table->string('id_kurir', 9)->nullable(true);
            $table->foreign('id_kantin')->references('id_kantin')->on('kantin')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_kurir')->nullable()->references('id_kurir')->on('kurir')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_penarikan');
    }
};
