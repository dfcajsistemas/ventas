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
        Schema::create('cuotas', function (Blueprint $table) {
            $table->id();

            $table->integer('numero');
            $table->decimal('monto', 10, 2);
            $table->timestamp('fvence');
            $table->tinyInteger('estado')->default(1)->nullable(); // null: pagada, 1: Pendiente

            $table->foreignId('venta_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cuotas');
    }
};
