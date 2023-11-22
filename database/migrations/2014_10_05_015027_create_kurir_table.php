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
        Schema::create('kurir', function (Blueprint $table) {
            $table->string('id_kurir', 9)->primary();
            $table->string('email', 100);
            $table->string('password', 100);
            $table->string('nama', 100);
            $table->boolean('status')->default(false);
            $table->string('token')->nullable(true);
            $table->string('token_fcm')->nullable(true);
            $table->string('telepon', 13);
            $table->string('foto', 255)->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kurir');
    }
};