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
        Schema::create('user', function (Blueprint $table) {
            $table->id('id_user');
            $table->string('username', 100);
            $table->string('email', 100);
            $table->string('password', 100);
            $table->integer('id_kantin')->nullable();
            $table->unsignedBigInteger('id_role')->nullable();
            $table->string('google_id')->nullable();
            $table->string('foto', 255)->nullable(true);
            $table->foreign('id_kantin')->references('id_kantin')->on('kantin')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('id_role')->references('id')->on('roles')->cascadeOnDelete()->cascadeOnUpdate();
            $table->rememberToken()->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user');
    }
};