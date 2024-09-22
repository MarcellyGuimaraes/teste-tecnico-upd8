<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepresentantesController;
use App\Http\Controllers\ClientesController;

Route::get('/', function () {
    return redirect('/representantes');
});

Route::get('representantes', [RepresentantesController::class, 'viewRepresentantes'])->name('representantes.index');
Route::get('representantes/{id}/clientes', [ClientesController::class, 'viewClientesRepresentante'])->name('representantes.clientes');