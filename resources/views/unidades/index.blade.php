@extends('index')

@section('conteudo')

<div class="container">
    <h2 style="display: inline-block;">Unidades</h2>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroUnidade" style="display: inline-block; margin-left: 10px; margin-down: 10px;">
        <i class="bi bi-plus"></i>
        +
    </button>

    <form method="GET" class="mb-3">
        <input type="text" name="abreviatura" value="{{ request('abreviatura') }}" class="form-control" placeholder="Buscar por abreviatura">
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>Abreviatura</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($unidades as $unidade)
            <tr>
                <td>{{ $unidade->abreviatura }}</td>
                <td>{{ $unidade->descricao }}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditarUnidade" data-unidade="{{ json_encode($unidade) }}">
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

    {{ $unidades->links() }}

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
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const unidade = JSON.parse(this.dataset.unidade);

            document.getElementById('editAbreviatura').value = unidade.abreviatura;
            document.getElementById('editDescricao').value = unidade.descricao;
            document.getElementById('formEditarUnidade').action = `/unidades/${unidade.id}`;
        });
    });
</script>

@endsection
