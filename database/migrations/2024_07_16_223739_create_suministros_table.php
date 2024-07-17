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
        Schema::create('suministros', function (Blueprint $table) {
            $table->id();

            $table->decimal('cantidad', 10, 2);
            $table->decimal('precio_costo', 10, 2)->nullable();
            $table->date('fec_envio')->nullable();
            $table->date('fec_recibido')->nullable();
            $table->string('observacion')->nullable();

            $table->foreignId('produccion_id')->constrained();
            $table->foreignId('sucursal_id')->constrained();
            $table->foreignId('sestado_id')->constrained();

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
        Schema::dropIfExists('suministros');
    }
};
