<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\RepresentantesController;
use App\Http\Controllers\CidadesController;
use App\Http\Controllers\EstadosController;

// Rotas CRUD para Clientes
Route::apiResource('clientes', ClientesController::class);

// Rotas CRUD para Representantes
Route::apiResource('representantes', RepresentantesController::class);
Route::post('representantes/{representante}/cidades', [RepresentantesController::class, 'addCidade']);

// Rotas somente GET para Cidades (listar e visualizar)
Route::get('cidades', [CidadesController::class, 'index']);
Route::get('cidades/{id}', [CidadesController::class, 'show']);

// Rotas somente GET para Estados (listar e visualizar)
Route::get('estados', [EstadosController::class, 'index']);
Route::get('estados/{id}', [EstadosController::class, 'show']);