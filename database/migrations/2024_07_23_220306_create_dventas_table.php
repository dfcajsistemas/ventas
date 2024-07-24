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
        Schema::create('dventas', function (Blueprint $table) {
            $table->id();

            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio', 10, 2);
            $table->decimal('igv', 14, 6)->nullable();
            $table->decimal('icbper', 14, 6)->nullable();
            $table->decimal('descuento', 14, 6)->nullable();
            $table->decimal('total', 14, 6);

            $table->foreignId('venta_id')->constrained();
            $table->foreignId('producto_id')->constrained();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dventas');
    }
};
