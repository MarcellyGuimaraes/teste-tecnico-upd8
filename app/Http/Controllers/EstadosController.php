<?php

namespace App\Http\Controllers;

use App\Models\Estado;

class EstadosController extends Controller
{
    public function index()
    {
        return Estado::all();  // Listar todos os estados
    }

    public function show($id)
    {
        return Estado::findOrFail($id);  // Exibir um estado específico
    }
}
