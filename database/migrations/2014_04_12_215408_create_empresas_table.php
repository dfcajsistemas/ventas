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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11)->unique();
            $table->string('razon_social');
            $table->string('nom_comercial')->nullable();
            $table->string('dom_fiscal')->nullable();
            $table->string('rep_legal')->nullable();
            $table->string('logo')->nullable();
            $table->string('certificado')->nullable();
            $table->string('pas_certificado', 15)->nullable();
            $table->date('ven_certificado')->nullable();
            $table->string('ubigeo', 6)->nullable();
            $table->string('usuario_sol')->nullable();
            $table->string('clave_sol')->nullable();

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
        Schema::dropIfExists('empresas');
    }
};
