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
        Schema::create('role_has_model', function (Blueprint $table) {
            $table->integer('id_roles');
            $table->string('model_type', 100);
            $table->integer('model_id');
            $table->foreign('id_roles')->references('id_detail_roles')->on('detail_role')->cascadeOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_has_model');
    }
};