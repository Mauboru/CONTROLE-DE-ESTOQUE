@extends('index')

@section('conteudo')

<div class="container mt-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Clientes</h2>
    </div>

    <form method="GET" class="mb-3 d-flex justify-content-between align-items-center">
        <div class="w-50">
            <input type="text" name="nome" value="{{ request('nome') }}" class="form-control" placeholder="Buscar por nome">
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroCliente">
            <i class="bi bi-plus"></i> Novo Cliente
        </button>
    </form>

    <!-- Tabela de Categorias -->
    <table class="table table-striped table-hover text-center">
        <thead class="table-light">
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
            <tr class="client-row" data-id="{{ $cliente->id }}" data-cliente="{{ json_encode($cliente) }}">
                <td>{{ $cliente->nome }}</td>
                <td>{{ $cliente->email }}</td>
                <td>{{ $cliente->telefone }}</td>
                <td>{{ $cliente->cpf }}</td>
                <td>{{ $cliente->endereco->cep }}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditarCliente">
                        Editar
                    </button>
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
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" required pattern="[A-Za-z\s]+">
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" name="telefone" required pattern="\d+">
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf-mask" name="cpf" required pattern="\d+">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control cep-mask" name="cep" id="cep" required pattern="\d{5}-?\d{3}">
                        </div>
                        <div class="mb-3">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" name="rua" id="rua" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" name="bairro" id="bairro" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" name="cidade" id="cidade" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" name="estado" id="estado" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" name="numero" required>
                        </div>
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
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="editNome" required>
                        </div>
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" name="telefone" id="editTelefone" required pattern="\d+">
                        </div>
                        <div class="mb-3">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control cpf-mask" name="cpf" id="editCpf" required pattern="\d{11}" title="O CPF deve conter exatamente 11 números.">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" name="email" id="editEmail" required>
                        </div>
                        <div class="mb-3">
                            <label for="cep" class="form-label">CEP</label>
                            <input type="text" class="form-control cep-mask" name="cep" id="editCep" required>
                        </div>
                        <div class="mb-3">
                            <label for="rua" class="form-label">Rua</label>
                            <input type="text" class="form-control" name="rua" id="editRua" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" name="bairro" id="editBairro" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" name="cidade" id="editCidade" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" name="estado" id="editEstado" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="numero" class="form-label">Número</label>
                            <input type="text" class="form-control" name="numero" id="editNumero" required>
                        </div>
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
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(event) {
            const cpfInputs = form.querySelectorAll('input[name="cpf"]');
            cpfInputs.forEach(cpfInput => {
                const cpf = cpfInput.value.replace(/\D/g, '');
                if (cpf.length !== 11) {
                    event.preventDefault();
                    alert('O CPF deve conter exatamente 11 números.');
                }
            });
        });
    });

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

    document.querySelectorAll('.client-row').forEach(row => {
        row.addEventListener('click', function() {
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

            const formEdit = document.getElementById('formEditarCliente');
            formEdit.action = `/clientes/${cliente.id}`;
        });
    });
</script>

@endsection
