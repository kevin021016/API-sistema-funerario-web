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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            
            // Datos personales
            $table->string('nombre');
            $table->string('apellidos');
            $table->date('fecha_nacimiento')->nullable();
            
            // Domicilio detallado
            $table->string('calle');
            $table->string('entre_calles')->nullable();
            $table->string('colonia');
            $table->string('ciudad');
            $table->string('codigo_postal', 10);
            $table->text('referencia_domicilio')->nullable();
            
            // Contacto
            $table->string('telefono', 20)->nullable();
            $table->string('celular', 20)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
