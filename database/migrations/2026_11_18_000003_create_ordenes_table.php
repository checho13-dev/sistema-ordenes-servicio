<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipo_id')->constrained('equipos')->restrictOnDelete();
            $table->text('falla_reportada');
            $table->text('diagnostico')->nullable();
            $table->decimal('costo_estimado', 12, 2)->nullable();
            $table->date('fecha_ingreso');
            $table->date('fecha_entrega')->nullable();
            $table->string('estado');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};
