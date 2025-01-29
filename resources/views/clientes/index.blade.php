@extends('index')

@section('conteudo')

<div class="container">
    <h2 style="display: inline-block;">Clientes</h2>
    <!-- Botão de Cadastro -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroCliente" style="display: inline-block; margin-left: 10px">
        <i class="bi bi-plus"></i>
        +
    </button>

    <!-- Filtro por Nome -->
    <form method="GET" class="mb-3">
        <input type="text" name="nome" value="{{ request('nome') }}" class="form-control" placeholder="Buscar por nome">
    </form>

    <!-- Tabela de Clientes -->
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>CPF</th>
                <th>CEP</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->telefone }}</td>
                <td>{{ $cliente->cpf }}</td>
                <td>{{ $cliente->endereco->cep }}</td>

                <!-- Ações -->
                <td>
                    <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditarCliente" data-cliente="{{ json_encode($cliente) }}">
                        Editar
                    </button>
                    <!-- Botão de Excluir -->
                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    {{ $clientes->links() }}

    <!-- Modal de Cadastro -->
    <div class="modal fade" id="modalCadastroCliente" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('clientes.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" required pattern="[A-Za-z\s]+">
                        </div>

                        <!-- Telefone -->
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" name="telefone" required pattern="\d+">
                        </div>

                        <!-- CPF -->
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf-mask" name="cpf" required pattern="\d+">
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <!-- CEP -->
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control cep-mask" name="cep" id="cep" required pattern="\d{5}-?\d{3}">
                        </div>

                        <!-- Rua -->
                        <div class="mb-3">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" name="rua" id="rua" required readonly>
                        </div>

                        <!-- Bairro -->
                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" name="bairro" id="bairro" required readonly>
                        </div>

                        <!-- Cidade -->
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" name="cidade" id="cidade" required readonly>
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" name="estado" id="estado" required readonly>
                        </div>

                        <!-- Número -->
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" name="numero" required>
                        </div>

                        <!-- Complemento -->
                        <div class="mb-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" name="complemento">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Edição -->
    <div class="modal fade" id="modalEditarCliente" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="formEditarCliente">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Cliente</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="editNome" required>
                        </div>

                        <!-- Telefone -->
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" name="telefone" id="editTelefone" required pattern="\d+">
                        </div>

                        <!-- CPF -->
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf-mask" name="cpf" id="editCpf" required>
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required>
                        </div>

                        <!-- CEP -->
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control cep-mask" name="cep" id="editCep" required>
                        </div>

                        <!-- Rua -->
                        <div class="mb-3">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" name="rua" id="editRua" required readonly>
                        </div>

                        <!-- Bairro -->
                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" name="bairro" id="editBairro" required readonly>
                        </div>

                        <!-- Cidade -->
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" name="cidade" id="editCidade" required readonly>
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" name="estado" id="editEstado" required readonly>
                        </div>

                        <!-- Número -->
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" name="numero" id="editNumero" required>
                        </div>

                        <!-- Complemento -->
                        <div class="mb-3">
                            <label for="complemento" class="form-label">Complemento</label>
                            <input type="text" class="form-control" name="complemento" id="editComplemento">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Salvar alterações</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('cep').addEventListener('blur', async function() {
        const cep = this.value.replace(/\D/g, '');
        if (cep.length === 8) {
            try {
                const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
                const data = await response.json();
                if (!data.erro) {
                    document.getElementById('rua').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('estado').value = data.uf || '';
                } else {
                    alert('CEP não encontrado.');
                }
            } catch (error) {
                console.error('Erro ao buscar o CEP:', error);
                alert('Erro ao buscar o CEP.');
            }
        } else {
            alert('Digite um CEP válido.');
        }
    });

    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const cliente = JSON.parse(this.dataset.cliente);

            document.getElementById('editNome').value = cliente.nome;
            document.getElementById('editTelefone').value = cliente.telefone;
            document.getElementById('editCpf').value = cliente.cpf;
            document.getElementById('editEmail').value = cliente.email;
            document.getElementById('editCep').value = cliente.endereco.cep;
            document.getElementById('editRua').value = cliente.endereco.rua;
            document.getElementById('editBairro').value = cliente.endereco.bairro;
            document.getElementById('editCidade').value = cliente.endereco.cidade;
            document.getElementById('editEstado').value = cliente.endereco.estado;
            document.getElementById('editNumero').value = cliente.endereco.numero;
            document.getElementById('editComplemento').value = cliente.endereco.complemento;

            document.getElementById('formEditarCliente').action = `/clientes/${cliente.id}`;
        });
    });
</script>

@endsection
