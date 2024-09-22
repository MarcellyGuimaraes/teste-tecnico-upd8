<?php
namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    public function index()
    {
        return Cliente::with('cidade')->get();
    }

    public function store(Request $request)
    {
        $cliente = Cliente::create($request->all());
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
}
