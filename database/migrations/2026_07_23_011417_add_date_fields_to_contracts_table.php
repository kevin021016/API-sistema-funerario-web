<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Añadimos los campos justo después del folio para mantener el orden
            $table->date('sale_date')->nullable()->after('folio');
            $table->date('first_payment_date')->nullable()->after('sale_date');
        });
    }

    public function down(): void
    {
        Schema::table('contracts', function (Blueprint $table) {
            // Si hacemos un rollback, eliminamos estas columnas
            $table->dropColumn(['sale_date', 'first_payment_date']);
        });
    }
};