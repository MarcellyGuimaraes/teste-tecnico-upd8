<?php

namespace App\Http\Controllers;

use App\Models\Cidade;

class CidadesController extends Controller
{
    public function index()
    {
        return Cidade::with('estado')->get();  // Listar todas as cidades com seus estados
    }

    public function show($id)
    {
        return Cidade::with('estado')->findOrFail($id);  // Exibir uma cidade específica
    }
}
