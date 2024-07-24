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
        Schema::create('autorizacions', function (Blueprint $table) {
            $table->id();

            $table->string('codigo', 6)->unique();
            $table->string('observacion');
            $table->string('descripcion');
            $table->tinyInteger('estado')->default(1)->nullable(); // 1: Activo, null: Inactivo

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
        Schema::dropIfExists('autorizacions');
    }
};
