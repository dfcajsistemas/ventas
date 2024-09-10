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
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();

            $table->string('serie', 4)->nullable();
            $table->unsignedBigInteger('correlativo')->nullable();
            $table->tinyInteger('fpago')->nullable();   // null: Contado, 1: Crédito
            $table->timestamp('femision')->nullable();
            $table->timestamp('fvencimiento')->nullable();
            $table->decimal('op_grabbadas', 14, 6)->nullable();
            $table->decimal('op_exoneradas', 14, 6)->nullable();
            $table->decimal('op_inafectas', 14, 6)->nullable();
            $table->decimal('igv', 14, 6)->nullable();
            $table->decimal('icbper', 14, 6)->nullable();
            $table->decimal('descuento', 14, 6)->nullable();
            $table->decimal('total', 14, 6)->nullable();
            $table->string('serie_ref')->nullable();
            $table->unsignedBigInteger('correlativo_ref')->nullable();
            $table->string('motivo_ref', 4)->nullable();
            $table->string('nombrexml', 50)->nullable();
            $table->text('xmlbase64')->nullable();
            $table->text('hash')->nullable();
            $table->text('cdrbase64')->nullable();
            $table->string('cod_sunat', 20)->nullable();
            $table->string('msj_sunat')->nullable();
            $table->tinyInteger('est_comprobante')->nullable(); // null: sin comprobante, 1: emitido, 2: enviado, 3: aceptado, 4: observado, 5: rechazado
            $table->tinyInteger('est_venta')->nullable(); // 1: solicitado, 2: delivery, 3: entregado
            $table->tinyInteger('est_pago')->nullable(); // null: pagada, 1: pendiente

            $table->foreignId('cliente_id')->constrained();
            $table->foreignId('tmoneda_id')->constrained();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('sucursal_id')->constrained();
            $table->foreignId('tcomprobante_id')->nullable()->constrained();

            $table->unsignedBigInteger('updated_by')->nullable()->index();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
