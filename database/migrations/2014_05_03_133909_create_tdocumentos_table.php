<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tdocumentos', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 2);
            $table->string('descripcion', 80);
            $table->string('abreviatura', 80);
            $table->tinyInteger('estado')->default(1)->nullable(); // 1: Activo, null: Inactivo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tdocumentos');
    }
};
