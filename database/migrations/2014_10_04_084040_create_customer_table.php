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
        Schema::create('customer', function (Blueprint $table) {
            $table->string('id_customer', 9)->primary();
            $table->string('nama', 100);
            $table->string('no_telepon', 13);
            $table->boolean('email_verified')->default(false);
            $table->string('kode_verified', 7)->nullable();
            $table->string('token')->nullable(true);
            $table->string('token_fcm')->nullable(true);
            $table->string('alamat', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('password', 100)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('google_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer');
    }
};