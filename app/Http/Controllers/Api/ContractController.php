<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Urn;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ContractController extends Controller
{
    /**
     * LEER: Listar todos los contratos con sus relaciones básicas.
     */
    public function index()
    {
        // Cargamos las relaciones 'urn' y 'baseService' para tener la info completa en el JSON
        $contracts = Contract::with(['urn', 'baseService', 'client', 'payments'])->latest()->get();
        return response()->json($contracts, 200);
    }

    /**
     * CARGAR CATÁLOGOS: Muestra los datos necesarios para armar el formulario en el Front.
     */
    public function create()
    {
        $packages = Service::where('is_base_package', true)->get();
        $extras = Service::where('is_base_package', false)->get();
        $urns = Urn::where('stock', '>', 0)->get();

        return response()->json([
            'packages' => $packages,
            'extras' => $extras,
            'urns' => $urns
        ], 200);
    }

    /**
     * CREAR: Almacena el contrato y descuenta del inventario.
     */
    public function store(Request $request)
    {
        $request->validate([
            'folio' => 'required|string|max:50|unique:contracts,folio',
            'sale_date' => 'required|date',
            'first_payment_date' => 'required_if:payment_scheme,2|nullable|date',
            'client_id' => 'required|exists:clients,id',
            'pet_name' => 'required|string|max:255',
            'pet_breed' => 'required|string|max:255',
            'pet_weight' => 'required|numeric|min:0',
            'base_service_id' => 'required|exists:services,id',
            'urn_id' => 'nullable|exists:urns,id',
            'subtotal_services' => 'required|numeric',
            'urn_price' => 'required|numeric',
            'subtotal_extras' => 'required|numeric',
            'total_price' => 'required|numeric',
            'payment_scheme' => 'required|in:1,2',
            'payment_amount' => 'required|numeric',
            'payment_frequency' => 'required_if:payment_scheme,2|nullable|in:unico,semanal,quincenal,mensual',
            'total_payments' => 'required_if:payment_scheme,2|nullable|integer|min:1',
            'down_payment' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // 1. Tomamos el folio directamente del request enviado por tu formulario
            $folio = $request->folio;

            // Control de Inventario: Verificar stock de la urna y descontar
            if ($request->filled('urn_id')) {
                $urn = Urn::findOrFail($request->urn_id);
                if ($urn->stock < 1) {
                    return response()->json(['message' => 'La urna seleccionada no tiene stock disponible'], 422);
                }
                $urn->decrement('stock', 1);
            }
            $montoAbonoInicial = floatval($request->input('down_payment', 0.00));

            $additionalServices = $request->input('additional_services', []);

            // 2. Guardamos el contrato usando el folio del input
            $contract = Contract::create([
                'folio' => $folio,
                'sale_date' => $request->sale_date,
                // Si es contado (1), guardamos null. Si es crédito (2), guardamos la fecha elegida.
                'first_payment_date' => $request->payment_scheme == '1' ? null : $request->first_payment_date,
                'client_id' => $request->client_id,
                'urn_id' => $request->urn_id,
                'base_service_id' => $request->base_service_id,
                'pet_name' => $request->pet_name,
                'pet_breed' => $request->pet_breed,
                'pet_weight' => $request->pet_weight,
                'subtotal_services' => $request->subtotal_services,
                'urn_price' => $request->urn_price,
                'subtotal_extras' => $request->subtotal_extras,
                'total_price' => $request->total_price,
                'payment_amount' => $request->payment_amount,
                'payment_scheme' => $request->payment_scheme,
                'payment_frequency' => $request->payment_scheme == '1' ? 'unico' : $request->payment_frequency,
                'total_payments' => $request->payment_scheme == '1' ? 1 : $request->total_payments,
                'down_payment' => $montoAbonoInicial,
                'additional_services_json' => $additionalServices,
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Contrato generado exitosamente',
                'contract' => $contract
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al crear el contrato', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * MOSTRAR DETALLE: Obtener un contrato específico por ID.
     */
    public function show($id)
    {
        $contract = Contract::with(['urn', 'baseService', 'client', 'payments'])->find($id);

        if (!$contract) {
            return response()->json(['message' => 'Contrato no encontrado'], 404);
        }

        return response()->json($contract, 200);
    }

    /**
     * EDITAR / ACTUALIZAR: Modifica los datos del contrato y recalcula el inventario de urnas si cambió.
     */
    public function update(Request $request, Contract $contract)
    {    
        $request->validate([
            'sale_date' => 'sometimes|required|date',
            'first_payment_date' => 'nullable|date',
            'pet_name' => 'sometimes|required|string|max:255',
            'pet_breed' => 'sometimes|required|string|max:255',
            'pet_weight' => 'sometimes|required|numeric|min:0',
            'urn_id' => 'nullable|exists:urns,id',
            'base_service_id' => 'sometimes|required|exists:services,id',
            'total_price' => 'sometimes|required|numeric',

            'total_payments' => 'sometimes|required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Lógica de inventario por si cambiaron la urna en la edición
            if ($request->has('urn_id') && $request->urn_id != $contract->urn_id) {

                // 1. Regresar al stock la urna anterior si existía
                if ($contract->urn_id) {
                    Urn::where('id', $contract->urn_id)->increment('stock', 1);
                }

                // 2. Descontar del stock la nueva urna seleccionada
                if ($request->urn_id) {
                    $newUrn = Urn::findOrFail($request->urn_id);
                    if ($newUrn->stock < 1) {
                        return response()->json(['message' => 'La nueva urna seleccionada no tiene stock'], 422);
                    }
                    $newUrn->decrement('stock', 1);
                }
            }

            // Si vienen servicios adicionales dinámicos, actualizamos el JSON
            if ($request->has('additional_services')) {
                $contract->additional_services_json = $request->input('additional_services');
            }

            // Actualizar los demás campos enviados
            $contract->update($request->except(['folio', 'client_id', 'additional_services']));

            DB::commit();

            return response()->json([
                'message' => 'Contrato actualizado correctamente',
                'contract' => $contract->load(['urn', 'baseService', 'client', 'payments'])
                
                
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al actualizar el contrato', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * ELIMINAR: Borra el contrato y regresa la urna ligada al inventario.
     */
    public function destroy(Contract $contract)
    {
        DB::beginTransaction();

        try {
            // Si el contrato tenía una urna asignada, la devolvemos al inventario
            if ($contract->urn_id) {
                Urn::where('id', $contract->urn_id)->increment('stock', 1);
            }

            // Eliminamos el contrato
            $contract->delete();

            DB::commit();

            return response()->json([
                'message' => 'Contrato eliminado correctamente y stock de urna restablecido'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al eliminar el contrato', 'error' => $e->getMessage()], 500);
        }
    }
}