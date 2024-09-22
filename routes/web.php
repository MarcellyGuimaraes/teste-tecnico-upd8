<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RepresentantesController;

Route::get('/', function () {
    return redirect('/representantes');
});

Route::get('representantes', [RepresentantesController::class, 'viewRepresentantes'])->name('representantes.index');
Route::get('representantes/{representante}/edit', [RepresentantesController::class, 'edit'])->name('representantes.edit');