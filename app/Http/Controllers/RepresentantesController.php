<?php
namespace App\Http\Controllers;

use App\Models\Representante;
use Illuminate\Http\Request;

class RepresentantesController extends Controller
{
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
}
