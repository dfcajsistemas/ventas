<?php

use App\Models\Sucursal;
use App\Models\Tcomprobante;
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
        Schema::create('series', function (Blueprint $table) {
            $table->id();

            $table->string('serie', 4)->unique();
            $table->unsignedBigInteger('correlativo')->default(0);
            $table->tinyInteger('estado')->default(1)->nullable(); // 1: Activo, null: Inactivo

            $table->foreignId('tcomprobante_id')->constrained();
            $table->foreignId('sucursal_id')->constrained();

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
        Schema::dropIfExists('series');
    }
};
