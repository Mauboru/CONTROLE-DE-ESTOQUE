@extends('index')

@section('conteudo')

<div class="container">
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
        <h2>Unidades</h2>
    </div>

    <form method="GET" class="mb-3 d-flex justify-content-between align-items-center">
        <div class="w-50">
            <input type="text" name="abreviatura" value="{{ request('abreviatura') }}" class="form-control" placeholder="Buscar por abreviatura">
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroUnidade">
            <i class="bi bi-plus"></i> Nova Unidade
        </button>
    </form>

    <!-- Tabela de Unidades -->
    <table class="table table-striped table-hover text-center w-100">
        <thead class="table-light">
            <tr>
                <th>Abreviatura</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($unidades as $unidade)
                <tr class="unidade-row" data-id="{{ $unidade->id }}" data-unidade="{{ json_encode($unidade) }}">
                    <td>{{ $unidade->abreviatura }}</td>
                    <td>{{ $unidade->descricao }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditarUnidade">
                            Editar
                        </button>
                        <form action="{{ route('unidades.destroy', $unidade->id) }}" method="POST" style="display: inline;">
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
    <div class="modal fade" id="modalCadastroUnidade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('unidades.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Unidade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="abreviatura" class="form-label">Abreviatura</label>
                            <input type="text" class="form-control" name="abreviatura" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" required></textarea>
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
    <div class="modal fade" id="modalEditarUnidade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="formEditarUnidade">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Unidade</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="abreviatura" class="form-label">Abreviatura</label>
                            <input type="text" class="form-control" name="abreviatura" id="editAbreviatura" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" id="editDescricao" required></textarea>
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
    document.querySelectorAll('.unidade-row').forEach(row => {
        row.addEventListener('click', function() {
            const unidade = JSON.parse(this.dataset.unidade); 
            document.getElementById('editAbreviatura').value = unidade.abreviatura;
            document.getElementById('editDescricao').value = unidade.descricao;

            const formEdit = document.getElementById('formEditarUnidade');
            formEdit.action = `/unidades/${unidade.id}`;
        });
    });
</script>

@endsection
