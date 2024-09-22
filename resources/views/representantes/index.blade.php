@extends('layouts.app')

@section('content')
<h1>Representantes</h1>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addRepresentanteModal">Adicionar Representante</button>

<table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Cidades</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($representantes as $representante)
            <tr>
                <td>{{ $representante->rep_nome }}</td>
                <td>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#verCidadesModal-{{ $representante->representante_id }}">Ver Cidades</button>
                </td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRepresentanteModal" data-representante-id="{{ $representante->representante_id }}" data-representante-nome="{{ $representante->rep_nome }}">Editar</a>
    
                    <form action="{{ route('representantes.destroy', $representante->representante_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                    <a href="{{ route('representantes.show', $representante->representante_id) }}" class="btn btn-info btn-sm">Ver Clientes</a>
                </td>
            </tr>

            <!-- Modal para exibir as cidades -->
            <div class="modal fade" id="verCidadesModal-{{ $representante->representante_id }}" tabindex="-1" aria-labelledby="verCidadesModalLabel-{{ $representante->representante_id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="verCidadesModalLabel-{{ $representante->representante_id }}">Cidades do Representante: {{ $representante->rep_nome }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <ul>
                                @foreach($representante->cidades as $cidade)
                                    <li>{{ $cidade->cid_nome }}</li>
                                @endforeach
                            </ul>

                            <!-- Botão de adicionar cidade dentro do modal -->
                            <button class="btn btn-success btn-sm mt-3" data-representante="{{ $representante->representante_id }}" data-bs-toggle="modal" data-bs-target="#addCidadeModal">Adicionar Cidade</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </tbody>
</table>

<!-- Modal para adicionar cidade -->
<div class="modal fade" id="addCidadeModal" tabindex="-1" aria-labelledby="addCidadeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCidadeModalLabel">Adicionar Cidade ao Representante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCidadeForm">
                    <input type="hidden" id="representante_id" name="representante_id" value="">
                    
                    <!-- Dropdown para selecionar o Estado -->
                    <div class="form-group">
                        <label for="estado_id">Selecione o Estado</label>
                        <select class="form-control" id="estado_id" name="estado_id" onchange="filtrarCidadesPorEstado()">
                            <option value="">Selecione um Estado</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->estado_id }}">{{ $estado->est_nome }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Dropdown para selecionar a Cidade (inicialmente vazio) -->
                    <div class="form-group mt-3">
                        <label for="cidade_id">Selecione a Cidade</label>
                        <select class="form-control" id="cidade_id" name="cidade_id" disabled>
                            <option value="">Selecione um Estado primeiro</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para adicionar representante -->
<div class="modal fade" id="addRepresentanteModal" tabindex="-1" aria-labelledby="addRepresentanteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRepresentanteModalLabel">Adicionar Representante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addRepresentanteForm">
                    @csrf
                    <div class="form-group">
                        <label for="rep_nome">Nome do Representante</label>
                        <input type="text" class="form-control" id="rep_nome" name="rep_nome" placeholder="Digite o nome do representante" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar representante -->
<div class="modal fade" id="editRepresentanteModal" tabindex="-1" aria-labelledby="editRepresentanteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editRepresentanteModalLabel">Editar Representante</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editRepresentanteForm" method="POST" action="">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="rep_nome">Nome do Representante</label>
                        <input type="text" class="form-control" id="rep_nome" name="rep_nome" placeholder="Digite o nome do representante" required>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">Salvar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Objeto que armazena as cidades por estado
    const cidadesPorEstado = @json($estados->pluck('cidades', 'estado_id'));

    function filtrarCidadesPorEstado() {
        const estadoId = document.getElementById('estado_id').value;
        const cidadeSelect = document.getElementById('cidade_id');

        // Limpar as opções de cidade
        cidadeSelect.innerHTML = '<option value="">Selecione uma Cidade</option>';
        cidadeSelect.disabled = true;

        // Verificar se um estado foi selecionado
        console.log(cidadesPorEstado)
        if (estadoId) {
            console.log(estadoId)
            const cidades = cidadesPorEstado[estadoId] || [];
            console.log(cidades)
            cidades.forEach(cidade => {
                const option = new Option(cidade.cid_nome, cidade.cidade_id);
                cidadeSelect.add(option);
            });
            cidadeSelect.disabled = false;
        }
    }

    // Script para capturar o ID do representante ao abrir o modal
    document.addEventListener('DOMContentLoaded', function () {
        var addCidadeModal = document.getElementById('addCidadeModal');
        addCidadeModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var representanteId = button.getAttribute('data-representante');
            var inputRepresentanteId = addCidadeModal.querySelector('#representante_id');
            inputRepresentanteId.value = representanteId;
        });

        // Submissão do formulário para adicionar cidade
        document.getElementById('addCidadeForm').addEventListener('submit', function (e) {
            e.preventDefault();
            var representanteId = document.getElementById('representante_id').value;
            var cidadeId = document.getElementById('cidade_id').value;

            axios.post(`/api/representantes/${representanteId}/cidades`, {
                cidade_id: cidadeId
            })
            .then(function (response) {
                alert('Cidade adicionada com sucesso!');
                location.reload();
            })
            .catch(function (error) {
                console.log(error);
                alert('Erro ao adicionar cidade.');
            });
        });
    });

     // Submissão do formulário para adicionar representante
     document.getElementById('addRepresentanteForm').addEventListener('submit', function (e) {
        e.preventDefault();
        var repNome = document.getElementById('rep_nome').value;

        axios.post('/api/representantes', {
            rep_nome: repNome
        })
        .then(function (response) {
            alert('Representante adicionado com sucesso!');
            location.reload(); // Recarregar a página para atualizar a lista
        })
        .catch(function (error) {
            console.log(error);
            alert('Erro ao adicionar representante.');
        });
    });

    // Abre o modal de adicionar cidade e carrega o ID do representante
    document.getElementById('addCidadeModal').addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var representanteId = button.getAttribute('data-representante');
        document.getElementById('representante_id').value = representanteId;
    });

    document.addEventListener('DOMContentLoaded', function () {
        const editRepresentanteModal = document.getElementById('editRepresentanteModal');
        var button;
        var representanteId;
        var representanteNome;
        var form;

        editRepresentanteModal.addEventListener('show.bs.modal', function (event) {
            button = event.relatedTarget;
            representanteId = button.getAttribute('data-representante-id');
            representanteNome = button.getAttribute('data-representante-nome');
            form = editRepresentanteModal.querySelector('#editRepresentanteForm');
            form.querySelector('#rep_nome').value = representanteNome;
        });

        editRepresentanteModal.addEventListener('submit', function (e) {
            e.preventDefault();
            var repNome = form.querySelector('#rep_nome').value;

            axios.put(`/api/representantes/${representanteId}`, {
                rep_nome: repNome
            })
            .then(function (response) {
                alert('Representante editado com sucesso!');
                // location.reload(); // Recarregar a página para atualizar a lista
            })
            .catch(function (error) {
                console.log(error);
                alert('Erro ao adicionar representante.');
            });
        });

    });

</script>
@endsection
