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
        Schema::create('model_has_permission', function (Blueprint $table) {
            $table->integer('id_permission');
            $table->string('model_type', 100);
            $table->integer('model_id');
            $table->foreign('id_permission')->references('id_permission')->on('permission')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mdoel_has_permission');
    }
};