<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('urns', function (Blueprint $table) {
            $table->id();
            $table->string('model_name'); // Ej: Urna Madera Clásica
            $table->integer('stock')->default(0); // Control de inventario
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('urns');
    }
};