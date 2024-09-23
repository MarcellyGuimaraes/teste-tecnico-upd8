@extends('layouts.app')

@section('content')
<h1>Clientes do Representante: {{ $representante->rep_nome }}</h1>

<button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addClienteModal">Adicionar Cliente</button>
<a href="/" class="btn btn-secondary mb-3">Voltar para representantes</a>

<table class="table">
    <thead>
        <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>Data de Nascimento</th>
            <th>Sexo</th>
            <th>Estado</th>
            <th>Cidade</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->cli_nome }}</td>
                <td>{{ $cliente->cli_cpf }}</td>
                <td>{{ \Carbon\Carbon::parse($cliente->cli_nascimento)->format('d/m/Y') }}</td>
                <td>{{ $cliente->cli_sexo == 'M' ? 'Masculino' : 'Feminino' }}</td>
                <td>{{ $cliente->estado->est_sigla }}</td>
                <td>{{ $cliente->cidade->cid_nome }}</td>
                <td>
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editClienteModal"
                    data-cliente-id="{{ $cliente->cliente_id }}"
                    data-cliente-nome="{{ $cliente->cli_nome }}"
                    data-cliente-cpf="{{ $cliente->cli_cpf }}"
                    data-cliente-nascimento="{{ $cliente->cli_nascimento }}"
                    data-cliente-endereco="{{ $cliente->cli_endereco }}"
                    data-cidade-id="{{ $cliente->cidade_id }}"
                    data-estado-id="{{ $cliente->estado_id }}">Editar</button>
                    <form action="{{ route('clientes.destroy', $cliente->cliente_id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                    <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#addRepresentanteModal" data-cliente-id="{{ $cliente->cliente_id }}">Adicionar Representante</button>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal para adicionar cliente -->
<div class="modal fade" id="addClienteModal" tabindex="-1" aria-labelledby="addClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addClienteModalLabel">Adicionar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addClienteForm">
                    @csrf
                    <input type="hidden" id="representante_id" name="representante_id" value="{{ $representante->representante_id }}">
                    
                    <!-- Select para estado -->
                    <div class="form-group">
                        <label for="estado_id">Estado</label>
                        <select class="form-control" id="estado_id" name="estado_id" required>
                            <option value="">Selecione um Estado</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->estado_id }}">{{ $estado->est_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select para cidade -->
                    <div class="form-group">
                        <label for="cidade_id">Cidade</label>
                        <select class="form-control" id="cidade_id" name="cidade_id" required>
                            <option value="">Selecione uma Cidade</option>
                        </select>
                    </div>

                    <!-- Outros campos -->
                    <div class="form-group">
                        <label for="cli_nome">Nome</label>
                        <input type="text" class="form-control" id="cli_nome" name="cli_nome" required>
                    </div>
                    <div class="form-group">
                        <label for="cli_cpf">CPF</label>
                        <input type="text" class="form-control" id="cli_cpf" name="cli_cpf" required>
                    </div>
                    <div class="form-group">
                        <label for="cli_nascimento">Data de Nascimento</label>
                        <input type="date" class="form-control" id="cli_nascimento" name="cli_nascimento" required>
                    </div>
                    <div class="form-group">
                        <label for="cli_sexo">Sexo</label>
                        <select class="form-control" id="cli_sexo" name="cli_sexo" required>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cli_endereco">Endereço</label>
                        <input type="text" class="form-control" id="cli_endereco" name="cli_endereco" required>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para editar cliente -->
<div class="modal fade" id="editClienteModal" tabindex="-1" aria-labelledby="editClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editClienteModalLabel">Editar Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editClienteForm" method="POST" action="{{ route('clientes.update', '') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="edit_cliente_id" name="cliente_id" value="">
                    
                    <!-- Select para estado -->
                    <div class="form-group">
                        <label for="edit_estado_id">Estado</label>
                        <select class="form-control" id="edit_estado_id" name="estado_id" required>
                            <option value="">Selecione um Estado</option>
                            @foreach($estados as $estado)
                                <option value="{{ $estado->estado_id }}">{{ $estado->est_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Select para cidade -->
                    <div class="form-group">
                        <label for="edit_cidade_id">Cidade</label>
                        <select class="form-control" id="edit_cidade_id" name="cidade_id" required>
                            <option value="">Selecione uma Cidade</option>
                        </select>
                    </div>

                    <!-- Outros campos -->
                    <div class="form-group">
                        <label for="edit_cli_nome">Nome</label>
                        <input type="text" class="form-control" id="edit_cli_nome" name="cli_nome" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_cli_cpf">CPF</label>
                        <input type="text" class="form-control" id="edit_cli_cpf" name="cli_cpf" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_cli_nascimento">Data de Nascimento</label>
                        <input type="date" class="form-control" id="edit_cli_nascimento" name="cli_nascimento" required>
                    </div>
                    <div class="form-group">
                        <label for="edit_cli_sexo">Sexo</label>
                        <select class="form-control" id="edit_cli_sexo" name="cli_sexo" required>
                            <option value="M">Masculino</option>
                            <option value="F">Feminino</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_cli_endereco">Endereço</label>
                        <input type="text" class="form-control" id="edit_cli_endereco" name="cli_endereco" required>
                    </div>
                    
                    <button type="submit" class="btn btn-primary mt-3">Salvar</button>
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
                <h6>Representantes Adicionados:</h6>
                <ul id="representantesAdicionados" class="list-group mb-3">
                    @foreach($clientes as $cliente)
                        @foreach($cliente->representantes as $representanteCliente)
                            <li class="list-group-item">
                                {{ $representanteCliente->rep_nome }}
                                <button type="button" class="btn btn-danger btn-sm float-end remove-representante"
                                    @if($representante->representante_id == $representanteCliente->representante_id)
                                        disabled
                                    @endif
                                    data-representante-id="{{ $representanteCliente->representante_id }}">
                                    Remover
                                </button>
                        
                            </li>
                        @endforeach
                    @endforeach
                </ul>

                <form id="addRepresentanteForm">
                    @csrf
                    <input type="hidden" id="cliente_id" name="cliente_id" value="">
                    
                    <div class="form-group">
                        <label for="representante_id">Selecionar Representante</label>
                        <select class="form-control" id="representante_id" name="representante_id" required>
                            <option value="">Selecione um Representante</option>
                            @foreach($representantesNaoAssociados as $representante)
                                <option value="{{ $representante->representante_id }}">{{ $representante->rep_nome }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Adicionar</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateCidades(estadoId) {
            var representanteId = document.getElementById('representante_id').value; // Obtenha o ID do representante

            axios.get('/api/cidades/' + estadoId + '/' + representanteId)
                .then(function (response) {
                    var cidadeSelect = document.getElementById('cidade_id');
                    var editCidadeSelect = document.getElementById('edit_cidade_id');
                    
                    cidadeSelect.innerHTML = '<option value="">Selecione uma Cidade</option>';
                    editCidadeSelect.innerHTML = '<option value="">Selecione uma Cidade</option>';

                    response.data.forEach(function (cidade) {
                        cidadeSelect.innerHTML += `<option value="${cidade.cidade_id}">${cidade.cid_nome}</option>`;
                        editCidadeSelect.innerHTML += `<option value="${cidade.cidade_id}">${cidade.cid_nome}</option>`;
                    });
                });
        }

        document.getElementById('estado_id').addEventListener('change', function () {
            var estadoId = this.value;
            if (estadoId) {
                updateCidades(estadoId);
            }
        });

        document.getElementById('edit_estado_id').addEventListener('change', function () {
            var estadoId = this.value;
            if (estadoId) {
                updateCidades(estadoId);
            }
        });

        $('#editClienteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var clienteId = button.data('cliente-id');
            var clienteNome = button.data('cliente-nome');
            var clienteCpf = button.data('cliente-cpf');
            var clienteNascimento = button.data('cliente-nascimento');
            var clienteEndereco = button.data('cliente-endereco');
            var cidadeId = button.data('cidade-id');
            var estadoId = button.data('estado-id');

            var modal = $(this);
            modal.find('#edit_cliente_id').val(clienteId);
            modal.find('#edit_cli_nome').val(clienteNome);
            modal.find('#edit_cli_cpf').val(clienteCpf);
            modal.find('#edit_cli_nascimento').val(clienteNascimento);
            modal.find('#edit_cli_endereco').val(clienteEndereco);

            modal.find('#edit_estado_id').val(estadoId).trigger('change'); 

            updateCidades(estadoId);
            
            setTimeout(function() {
                modal.find('#edit_cidade_id').find(`option[value="${cidadeId}"]`).prop('selected', true);
            }, 500);
        });

        document.getElementById('addClienteForm').addEventListener('submit', function (event) {
            event.preventDefault(); 

            var formData = new FormData(this);

            axios.post('/api/clientes', formData)
                .then(function (response) {
                    location.reload();
                })
                .catch(function (error) {
                    console.error(error);
                    alert('Erro ao adicionar cliente.');
                });
        });

        $('#addRepresentanteModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var clienteId = button.data('cliente-id');

            var modal = $(this);
            modal.find('#cliente_id').val(clienteId);

            updateRepresentantesAdicionados(clienteId);
        });

        function updateRepresentantesAdicionados(clienteId) {
            var lista = $('#representantesAdicionados');
            lista.empty();
            
            axios.get('/api/clientes/' + clienteId + '/representantes')
            .then(function (response) {
                response.data.forEach(function (representanteCliente) {
                    var disabledButton = representanteCliente.representante_id != {{ $representante->representante_id }} ? 'disabled' : '';
                    
                    lista.append(`
                        <li class="list-group-item">
                            ${representanteCliente.rep_nome}
                            <button type="button" class="btn btn-danger btn-sm float-end remove-representante" ${disabledButton} data-representante-id="${representanteCliente.representante_id}">Remover</button>
                        </li>
                    `);
                });
            });
        }

        document.getElementById('addRepresentanteForm').addEventListener('submit', function (event) {
            event.preventDefault(); 
            var formData = new FormData(this); 

            axios.post('/api/clientes/' + this.cliente_id.value + '/representantes', formData)
                .then(function (response) {
                    updateRepresentantesAdicionados(formData.get('cliente_id'));
                    document.getElementById('representante_id').value = '';
                    location.reload();
                })
                .catch(function (error) {
                    console.error(error);
                    alert('Erro ao adicionar representante.'); 
                });
        });

        $(document).on('click', '.remove-representante', function () {
            var representanteId = $(this).data('representante-id');
            var clienteId = $('#cliente_id').val();

            axios.delete('/api/clientes/' + clienteId + '/representantes/' + representanteId)
                .then(function (response) {
                    updateRepresentantesAdicionados(clienteId);
                })
                .catch(function (error) {
                    console.error(error);
                    alert('Erro ao remover representante.'); 
                });
        });

    });
</script>
@endsection
