<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mensajes', function (Blueprint $table) {
            $table->id();
            $table->integer('remitente');
            $table->integer('destinatario');
            $table->foreignId('id_depa_a')->constrained('departamentos');
            $table->foreignId('id_depa_b')->constrained('departamentos');
            $table->string('mensaje');
            $table->timestamp('fecha');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mensajes');
    }
};
