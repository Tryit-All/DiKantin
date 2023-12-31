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
        Schema::create('kantin', function (Blueprint $table) {
            $table->integer('id_kantin')->primary();
            $table->string('nama', 100);
            $table->boolean('status');
            $table->bigInteger('total_saldo')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kantin');
    }
};