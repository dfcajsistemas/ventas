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
            //$table->tinyInteger('doc_tipo'); // 1 - DNI, 2 - Carnet de Extranjería, 3 - Pasaporte
            $table->string('ndocumento', 15)->unique();
            $table->string('email')->unique();
            $table->date('fec_nac')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();

            $table->tinyInteger('estado')->nullable()->default(1); // 1 - Habilitado, null - Deshabilitado

            $table->unsignedBigInteger('tdocumento_id');
            $table->foreign('tdocumento_id')->references('id')->on('tdocumentos');

            $table->unsignedBigInteger('sucursal_id');
            $table->foreign('sucursal_id')->references('id')->on('sucursals');

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
