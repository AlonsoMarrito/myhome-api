<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->integer('mes');
            $table->integer('año');
            $table->foreignId('id_depa')->constrained('departamentos');
            $table->boolean('completado');
            $table->decimal('monto', 10, 2);
            $table->foreignId('id_pago')->constrained('pagos');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
