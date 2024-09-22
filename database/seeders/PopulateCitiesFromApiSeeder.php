<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Estado;
use App\Models\Cidade;

class PopulateCitiesFromApiSeeder extends Seeder
{
    public function run()
    {
        // 1. Buscar todos os estados
        $estadosResponse = Http::get('https://servicodados.ibge.gov.br/api/v1/localidades/estados');
        $estados = $estadosResponse->json();

        // 2. Inserir estados no banco
        foreach ($estados as $estado) {
            $novoEstado = Estado::create([
                'est_nome' => $estado['nome'],
                'est_sigla' => $estado['sigla'],
            ]);

            // 3. Para cada estado, buscar suas cidades
            $cidadesResponse = Http::get("https://servicodados.ibge.gov.br/api/v1/localidades/estados/{$estado['id']}/municipios");
            $cidades = $cidadesResponse->json();

            foreach ($cidades as $cidade) {
                Cidade::create([
                    'cid_nome' => $cidade['nome'],
                    'estado_id' => $novoEstado->estado_id,
                ]);
            }
        }
    }
}
