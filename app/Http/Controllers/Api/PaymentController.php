<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Listar pagos
     */
    public function index()
    {
        $payments = Payment::with('contract')
            ->latest()
            ->get();

        return response()->json($payments, 200);
    }

    /**
     * Crear pago
     */
    public function store(Request $request)
    {
        $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_date' => 'required|date',
            'payment_type' => 'nullable|string|max:36',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment = Payment::create([
            'contract_id' => $request->contract_id,
            'amount' => $request->amount,
            'payment_date' => $request->payment_date,
            'payment_type' => $request->payment_type,
            'notes' => $request->notes,
        ]);

        return response()->json([
            'message' => 'Pago registrado correctamente',
            'payment' => $payment
        ], 201);
    }

    /**
     * Mostrar un pago
     */
    public function show(Payment $payment)
    {
        return response()->json(
            $payment->load('contract'),
            200
        );
    }

    /**
     * Actualizar pago
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'amount' => 'sometimes|required|numeric|min:0.01',
            'payment_date' => 'sometimes|required|date',
            'payment_type' => 'nullable|string|max:36',
            'notes' => 'nullable|string|max:500',
        ]);

        $payment->update($request->only([
            'amount',
            'payment_date',
            'payment_type',
            'notes'
        ]));

        return response()->json([
            'message' => 'Pago actualizado correctamente',
            'payment' => $payment
        ], 200);
    }

    /**
     * Eliminar pago
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json([
            'message' => 'Pago eliminado correctamente'
        ], 200);
    }
}