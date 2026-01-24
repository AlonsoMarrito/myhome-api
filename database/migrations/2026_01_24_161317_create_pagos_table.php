<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_depa')->constrained('departamentos');
            $table->decimal('monto', 10, 2);
            $table->foreignId('id_tipo')->constrained('tipo_pago');
            $table->date('fecha');
            $table->foreignId('id_motivo')->constrained('motivos');
            $table->string('descripcion');
            $table->string('comprobante');
            $table->boolean('efectuado');
            $table->foreignId('id_reporte')->constrained('reportes');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
