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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->tinyInteger('doc_tipo'); // 1 - DNI, 2 - Carnet de Extranjería, 3 - Pasaporte
            $table->string('doc_numero', 15);
            $table->tinyInteger('sexo'); // 1 - Masculino, 2 - Feminino
            $table->string('email')->unique();
            $table->string('email_ins')->nullable();
            $table->date('fec_nac');
            $table->tinyInteger('est_civil'); // 1 - Soltero, 2 - Casado, 3 - Divorciado, 4 - Viudo, 5 - Conviviente
            $table->string('gru_san', 3); // A+, A-, B+, B-, AB+, AB-, O+, O-
            $table->string('cuenta_bn', 40)->nullable();
            $table->string('autogenerado', 25)->nullable();
            $table->string('ruc', 11)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->unsignedBigInteger('distrito_id');
            $table->foreign('distrito_id')->references('id')->on('distritos');

            $table->tinyInteger('estado')->nullable()->default(1); // 1 - Habilitado, null - Deshabilitado

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
        Schema::dropIfExists('users');
    }
};
