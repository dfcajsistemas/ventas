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
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();

            $table->decimal('monto', 10, 2);
            $table->string('observacion')->nullable();
            $table->string('estado')->nullable(); // null pagado, 1 anulado

            $table->foreignId('venta_id')->constrained();
            $table->foreignId('caja_id')->constrained();
            $table->foreignId('mpago_id')->constrained();
            $table->foreignId('cuota_id')->nullable()->constrained();

            $table->unsignedBigInteger('created_by')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
