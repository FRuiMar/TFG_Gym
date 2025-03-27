<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\APIUserController;

// Ruta de prueba
// Route::get('/test', function () {
//     return response()->json(['message' => 'API funcionando genial y estupendamente como yo']);
// });


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');









// Rutas para usuarios
Route::apiResource('api-users', APIUserController::class);


// Route::get('/api-users', [APIUserController::class, 'index'])->middleware('auth:sanctum');
// Route::get('/api-users/{id}', [APIUserController::class, 'show'])->middleware('auth:sanctum');
// Route::put('/api-users/{id}', [APIUserController::class, 'update'])->middleware('auth:sanctum', 'can:update-user,id');
// Route::post('/api-users', [APIUserController::class, 'store'])->middleware('auth:sanctum', 'can:create-user');
// Route::delete('/api-users/{id}', [APIUserController::class, 'destroy'])->middleware('auth:sanctum', 'can:delete-user,id');
