<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Catálogo de Servicios Base (Paquetes de Cremación)
        $basePackages = [
            [
                'name' => 'Cremación Individual Chica (0-10 kg)',
                'default_price' => 2200.00,
                'is_base_package' => true,
            ],
            [
                'name' => 'Cremación Individual Mediana (11-25 kg)',
                'default_price' => 2800.00,
                'is_base_package' => true,
            ],
            [
                'name' => 'Cremación Individual Grande (26-40 kg)',
                'default_price' => 3500.00,
                'is_base_package' => true,
            ],
            [
                'name' => 'Cremación Comunitaria / Colectiva',
                'default_price' => 1200.00,
                'is_base_package' => true,
            ],
        ];

        foreach ($basePackages as $package) {
            Service::create($package);
        }

        // 2. Catálogo de Servicios Adicionales (Extras del Modal)
        $extraServices = [
            [
                'name' => 'Recolección Nocturna (Fuera de horario)',
                'default_price' => 500.00,
                'is_base_package' => false,
            ],
            [
                'name' => 'Certificado de Cremación Extra',
                'default_price' => 300.00,
                'is_base_package' => false,
            ],
            [
                'name' => 'Traslado Foráneo / Zonas Extendidas',
                'default_price' => 800.00,
                'is_base_package' => false,
            ],
            [
                'name' => 'Flores de Acompañamiento y Despedida',
                'default_price' => 250.00,
                'is_base_package' => false,
            ],
            [
                'name' => 'Sala de Espera / Despedida Presencial',
                'default_price' => 600.00,
                'is_base_package' => false,
            ],
        ];

        foreach ($extraServices as $extra) {
            Service::create($extra);
        }
    }
}