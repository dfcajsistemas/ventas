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
        Schema::create('sucursals', function (Blueprint $table) {
            $table->id();

            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono', 15)->nullable();
            $table->string('cod_sunat', 6)->nullable();
            $table->tinyInteger('p_venta')->default(1); //Existen 3 precios de venta
            $table->tinyInteger('p_descuento')->nullable();
            $table->date('v_descuento')->nullable();

            $table->tinyInteger('estado')->default(1)->nullable(); //1 activo, null inactivo

            $table->unsignedBigInteger('empresa_id');
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->unsignedBigInteger('distrito_id');
            $table->foreign('distrito_id')->references('id')->on('distritos');

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
        Schema::dropIfExists('sucursals');
    }
};
