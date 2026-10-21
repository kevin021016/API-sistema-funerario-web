<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique(); // ID único del contrato generado
            
            // Relaciones
            // Asumo que tienes una tabla de usuarios o clientes ya creada
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade'); 
            $table->foreignId('urn_id')->nullable()->constrained('urns')->onDelete('set null');
            $table->foreignId('base_service_id')->constrained('services'); // El paquete de cremación
            
            // 1. Datos de la Mascota
            $table->string('pet_name');
            $table->string('pet_breed');
            $table->decimal('pet_weight', 5, 2);
            
            // 2. Resumen de Cobro
            $table->decimal('subtotal_services', 8, 2);
            $table->decimal('urn_price', 8, 2)->default(0.00);
            $table->decimal('subtotal_extras', 8, 2)->default(0.00);
            $table->decimal('total_price', 8, 2);
            
            // 3. Esquema de Pago
            $table->enum('payment_scheme', ['1', '2']); // 1 = Contado, 2 = Crédito
            $table->enum('payment_frequency', ['unico', 'semanal', 'quincenal', 'mensual'])->default('unico');
            $table->integer('total_payments')->nullable()->default(1);
            $table->decimal('down_payment', 8, 2)->default(0.00); // Enganche
            
            // Almacén de los servicios extras agregados dinámicamente en formato JSON
            $table->json('additional_services_json')->nullable(); 
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};