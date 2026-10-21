<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contract;
use App\Models\Client;
use App\Models\Service;
use App\Models\Urn;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificamos que existan datos previos necesarios en las relaciones
        $clients = Client::all();
        $baseServices = Service::where('is_base_package', true)->get();$urns = Urn::all();

        if ($clients->isEmpty() || $baseServices->isEmpty()) {$this->command->warn('⚠️ Faltan registros en las tablas `clients` o `services` (paquetes base). Por favor ejecuta primero sus seeders.');
            return;
        }

        $petNames = ['Max', 'Luna', 'Rocky', 'Coco', 'Kira', 'Thor', 'Nala', 'Simba', 'Canela', 'Firulais', 'Zeus', 'Lola', 'Boby', 'Princesa', 'Toby'];$petBreeds = ['Labrador', 'Mestizo', 'Golden Retriever', 'Poodle', 'Schnauzer', 'Chihuahua', 'Pitbull', 'Husky', 'Gato Doméstico', 'Bulldog Francés'];

        DB::beginTransaction();

        try {
            for ($i = 1; $i <= 15; $i++) {
                $client =$clients->random();
                $baseService =$baseServices->random();
                
                // Ocasionalmente asignamos una urna o dejamos null (50% de probabilidad si hay stock)
                $urn = null;
                $urnPrice = 0;
                if ($urns->isNotEmpty() && rand(0, 1) === 1) {
                    $selectedUrn =$urns->random();
                    if ($selectedUrn->stock > 0) {
                        $urn =$selectedUrn;
                        $urnPrice =$urn->price ?? 850.00; // Ajusta según el campo de precio de tu modelo Urn
                        // Descontamos stock simulando el comportamiento del controlador
                        $urn->decrement('stock', 1);
                    }
                }

                $subtotalServices =$baseService->price ?? 1500.00; // Ajusta según tu campo de precio en Service
                $subtotalExtras = 0.00;
                $totalPrice =$subtotalServices + $urnPrice +$subtotalExtras;

                // Definir esquema de pago aleatorio: 1 = Contado, 2 = Crédito
                $paymentScheme = rand(1, 2) === 1 ? '1' : '2';
                
                if ($paymentScheme === '1') {
                    $paymentFrequency = 'unico';$totalPayments = 1;
                    $paymentAmount =$totalPrice;
                    $downPayment = 0.00;
                    $firstPaymentDate = null;
                } else {
                    $paymentFrequency = ['semanal', 'quincenal', 'mensual'][rand(0, 2)];$totalPayments = rand(3, 12);
                    $paymentAmount = round($totalPrice / $totalPayments, 2);$downPayment = 200.00;
                    $firstPaymentDate = Carbon::now()->addDays(rand(1, 7))->format('Y-m-d');
                }

                Contract::create([
                    'folio' => 'FOLIO-' . str_pad($i, 4, '0', STR_PAD_LEFT),
                    'sale_date' => Carbon::now()->subDays(rand(0, 30))->format('Y-m-d'),
                    'first_payment_date' => $firstPaymentDate,
                    'client_id' => $client->id,
                    'urn_id' => $urn ? $urn->id : null,
                    'base_service_id' => $baseService->id,
                    'pet_name' => $petNames[$i - 1],
                    'pet_breed' => $petBreeds[array_rand($petBreeds)],
                    'pet_weight' => rand(3, 35) + (rand(0, 9) / 10),
                    'subtotal_services' => $subtotalServices,
                    'urn_price' => $urnPrice,
                    'subtotal_extras' => $subtotalExtras,
                    'total_price' => $totalPrice,
                    'payment_amount' => $paymentAmount,
                    'payment_scheme' => $paymentScheme,
                    'payment_frequency' => $paymentFrequency,
                    'total_payments' => $totalPayments,
                    'down_payment' => $downPayment,
                    'additional_services_json' => [],
                ]);
            }

            DB::commit();
            $this->command->info('✅ ¡Se han generado 15 contratos exitosamente!');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->command->error('❌ Error al generar los contratos: ' . $e->getMessage());
        }
    }
}