<?php
namespace App\Http\Controllers;

use App\Models\Representante;
use Illuminate\Http\Request;
use App\Models\Estado;
use App\Models\Cidade;

class RepresentantesController extends Controller
{
    public function viewRepresentantes()
    {
        $representantes = Representante::with('cidades')->get();
        $estados = Estado::with('cidades')->get(); // Obter todos os estados com suas cidades
        
        return view('representantes.index', compact('representantes', 'estados'));
    }
    
    public function index()
    {
        return Representante::with('cidades', 'clientes')->get();
    }

    public function store(Request $request)
    {
        $representante = Representante::create($request->all());
        return response()->json($representante, 201);
    }

    public function show($id)
    {
        return Representante::with('cidades', 'clientes')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $representante = Representante::findOrFail($id);
        $representante->update($request->all());
        return response()->json($representante, 200);
    }

    public function destroy($id)
    {
        Representante::destroy($id);
        return response()->json(null, 204);
    }

    public function addCidade(Request $request, $representante_id)
    {
        $representante = Representante::findOrFail($representante_id);
        $cidade = Cidade::findOrFail($request->cidade_id);
    
        // Adiciona a cidade ao representante (many-to-many)
        $representante->cidades()->attach($cidade->cidade_id);
    
        return response()->json(['message' => 'Cidade adicionada com sucesso'], 200);
    }
}
