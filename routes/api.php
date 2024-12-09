<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CitasController;
use App\Http\Controllers\DoctoresController;
use App\Http\Controllers\ExpedienteMedicoController;
use App\Http\Controllers\PacientesController;
use App\Http\Controllers\TratamientosController;
use App\Http\Controllers\AuthController;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('citas', CitasController::class);
    Route::resource('doctores', DoctoresController::class);
    Route::resource('expedientes', ExpedienteMedicoController::class);
    Route::resource('pacientes', PacientesController::class);
    Route::resource('tratamientos', TratamientosController::class);

    Route::get('allexpedientes', [ExpedienteMedicoController::class, 'allexpedientes']);
    Route::get('allpacientes', [PacientesController::class, 'all']);
    Route::get('expedientespordoctor', [ExpedienteMedicoController::class, 'expedientesPorDoctor']);
    Route::get('pacientespordoctor', [PacientesController::class, 'pacientesPorDoctor']);
        Route::get('auth/logout', [AuthController::class, 'logout']);
});

