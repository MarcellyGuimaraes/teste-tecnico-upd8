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
    
    public function getCidadesPorEstadoRepresentante($estadoId, $representanteId)
    {
        // Obtenha as cidades que o representante atua no estado específico
        $cidades = Cidade::where('estado_id', $estadoId)
            ->whereHas('representantes', function ($query) use ($representanteId) {
                // Especifique a tabela 'representante_cidade'
                $query->where('representante_cidade.representante_id', $representanteId);
            })->get();
        
        return response()->json($cidades);
    }
    
}
