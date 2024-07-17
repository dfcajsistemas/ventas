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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();

            $table->string('razon_social');
            $table->string('ndocumento', 15)->unique();
            $table->string('correo')->nullable();
            $table->string('telefono', 15)->nullable();
            $table->string('direccion')->nullable();
            $table->string('referencia')->nullable();
            $table->string('ubigeo', 6)->nullable();

            $table->tinyInteger('estado')->default(1)->nullable(); // 1: Activo, null: Inactivo

            $table->foreignId('tdocumento_id')->constrained();

            $table->unsignedBigInteger('created_by')->nullable()->index();
            $table->unsignedBigInteger('updated_by')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
