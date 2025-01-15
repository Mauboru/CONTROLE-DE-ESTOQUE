@extends('index')

@section('conteudo')

<div class="container">
    <h2 style="display: inline-block;">Categorias</h2>
    <!-- Botão de Cadastro -->
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroCategoria" style="display: inline-block; margin-left: 10px; margin-down: 10px;">
        <i class="bi bi-plus"></i>
        +
    </button>

    <!-- Filtro por Nome -->
    <form method="GET" class="mb-3">
        <input type="text" name="nome" value="{{ request('nome') }}" class="form-control" placeholder="Buscar por nome">
    </form>

    <!-- Tabela de Categorias -->
    <table class="table">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorias as $categoria)
            <tr>
                <td>{{ $categoria->nome }}</td>
                <td>{{ $categoria->descricao }}</td>

                <!-- Ações -->
                <td>
                    <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditarCategoria" data-categoria="{{ json_encode($categoria) }}">
                        Editar
                    </button>
                    <!-- Botão de Excluir -->
                    <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST" style="display: inline;">
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
    {{ $categorias->links() }}

    <!-- Modal de Cadastro -->
    <div class="modal fade" id="modalCadastroCategoria" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('categorias.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>

                        <!-- Descrição -->
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
    <div class="modal fade" id="modalEditarCategoria" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" id="formEditarCategoria">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Categoria</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Nome -->
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="editNome" required>
                        </div>

                        <!-- Descrição -->
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
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const categoria = JSON.parse(this.dataset.categoria);

            document.getElementById('editNome').value = categoria.nome;
            document.getElementById('editDescricao').value = categoria.descricao;
            document.getElementById('formEditarCategoria').action = `/categorias/${categoria.id}`;
        });
    });
</script>

@endsection
