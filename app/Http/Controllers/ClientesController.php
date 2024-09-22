<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Representante;
use App\Models\Estado;
use App\Models\Cidade;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index()
    {
        return Cliente::with('representantes')->get();
    }

    public function store(Request $request)
    {
        $cliente = Cliente::create($request->all());
        $cliente->representantes()->attach($request->representante_id);

        return response()->json($cliente, 201);
    }

    public function show($id)
    {
        return Cliente::with('cidade')->findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->all());
        return response()->json($cliente, 200);
    }

    public function destroy($id)
    {
        Cliente::destroy($id);
        return response()->json(null, 204);
    }

    public function addRepresentante(Request $request, $clienteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $cliente->representantes()->attach($request->representante_id);

        return response()->json($cliente->representantes, 201);
    }

    public function getRepresentantes($clienteId)
    {
        $cliente = Cliente::with('representantes')->findOrFail($clienteId);
        return response()->json($cliente->representantes);
    }
    
    public function removeRepresentante($clienteId, $representanteId)
    {
        $cliente = Cliente::findOrFail($clienteId);
        $cliente->representantes()->detach($representanteId);

        return response()->json(null, 204);
    }

    public function viewClientesRepresentante($representanteId)
    {
        $clientes = Cliente::with('cidade')->with('estado')->whereHas('representantes', function ($query) use ($representanteId) {
            $query->where('representante_cliente.representante_id', $representanteId);
        })->get();
    
        $representante = Representante::findOrFail($representanteId);
        $representantes = Representante::all();
    
        $estados = Estado::whereIn('estado_id', $representante->cidades->pluck('estado_id'))->get();
        $cidades = Cidade::whereIn('estado_id', $representante->cidades->pluck('estado_id'))->get();
        $representantesNaoAssociados = Representante::whereNotIn('representante_id', $clientes->pluck('representantes.*.representante_id')->flatten())->get();

        return view('clientes.index', compact('clientes', 'representante', 'estados', 'cidades', 'representantes', 'representantesNaoAssociados'));
    }
}
