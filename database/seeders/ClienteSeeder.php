<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClienteSeeder extends Seeder
{
    public function run(): void
    {
        // Crea exactamente 15 clientes
        Client::factory()->count(15)->create();
    }
}