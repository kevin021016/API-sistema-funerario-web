<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\API\ClientController;
use App\Http\Controllers\API\ColoniaController;
use App\Http\Controllers\API\ContractController;
use App\Http\Controllers\API\PaymentController;


// RUTA PÚBLICA: Aquí es donde pedimos el Token
Route::post('/login', [AuthController::class, 'login']);

// RUTAS PROTEGIDAS: Requieren el Token en el Header
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/users', [UserController::class, 'index']);
    Route::post('/users', [UserController::class, 'store']);
    // Obtener un usuario: GET /api/users/1
    Route::get('/users/{id}', [UserController::class, 'show']);
    // Actualizar un usuario: PUT o POST /api/users/1 
    // (Se recomienda PUT para actualizaciones)
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);

    //------------CLIENTES------------------------
    Route::get('/clients', [ClientController::class, 'index']);
    Route::post('/clients', [ClientController::class, 'store']);
    // Obtener un usuario: GET /api/users/1
    Route::get('/clients/{id}', [ClientController::class, 'show']);
    // Actualizar un usuario: PUT o POST /api/users/1 
    // (Se recomienda PUT para actualizaciones)
    Route::put('/clients/{id}', [ClientController::class, 'update']);
    Route::delete('/clients/{id}', [ClientController::class, 'destroy']);

    Route::get('/colonias', [ColoniaController::class, 'index']);
    Route::post('/colonias', [ColoniaController::class, 'store']);

    //------------CONTRATOS (FUNERARIA MASCOTAS)------------------------
    // 2. Esta es la ruta que faltaba para que Vue cargue los paquetes, extras y urnas
    Route::get('/contracts/create', [ContractController::class, 'create']);

    // Rutas estándar del CRUD para Contratos
    Route::get('/contracts', [ContractController::class, 'index']);
    Route::post('/contracts', [ContractController::class, 'store']);
    Route::get('/contracts/{id}', [ContractController::class, 'show']);
    Route::put('/contracts/{contract}', [ContractController::class, 'update']);
    Route::delete('/contracts/{contract}', [ContractController::class, 'destroy']);

    // Rutas del CRUD para los pagos (payments)
    Route::get('/payments', [PaymentController::class, 'index']);
    Route::post('/payments', [PaymentController::class, 'store']);
    Route::get('/payments/{payment}', [PaymentController::class, 'show']);
    Route::put('/payments/{payment}', [PaymentController::class, 'update']);
    Route::delete('/payments/{payment}', [PaymentController::class, 'destroy']);
});
