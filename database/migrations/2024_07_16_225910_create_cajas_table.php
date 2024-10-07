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
        Schema::create('cajas', function (Blueprint $table) {
            $table->id();

            $table->timestamp('apertura');
            $table->timestamp('cierre')->nullable();
            $table->decimal('monto_cierre', 8, 2)->nullable();
            $table->tinyInteger('pendiente')->nullable(); // 1: pendiente, null: sin pendientes

            $table->foreignId('user_id')->constrained();
            $table->foreignId('sucursal_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
