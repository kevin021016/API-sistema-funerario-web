<?php

namespace Database\Seeders;

use App\Models\Urn;
use Illuminate\Database\Seeder;

class UrnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $urns = [
            [
                'model_name' => 'Urna de Madera Clásica',
                'stock' => 15,
            ],
            [
                'model_name' => 'Urna de Cerámica Blanca con Huella',
                'stock' => 8,
            ],
            [
                'model_name' => 'Urna Metálica Plateada Elegance',
                'stock' => 5,
            ],
            [
                'model_name' => 'Urna Biodegradable (Ecológica)',
                'stock' => 12,
            ],
            [
                'model_name' => 'Urna de MDF Grabado Premium',
                'stock' => 20,
            ],
        ];

        foreach ($urns as $urn) {
            Urn::create($urn);
        }
    }
}