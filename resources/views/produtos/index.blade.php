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
        <h2>Produtos</h2>
    </div>

    <form method="GET" class="mb-3 d-flex justify-content-between align-items-center">
        <div class="w-50">
            <input type="text" name="nome" value="{{ request('nome') }}" class="form-control" placeholder="Buscar por nome">
        </div>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroProduto">
            <i class="bi bi-plus"></i> Novo Produto
        </button>
    </form>

    <!-- Tabela -->
    <table class="table table-striped table-hover text-center w-100">
        <thead class="table-light">
            <tr>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Unidade de Medida</th>
                <th>Valor Unitário</th>
                <th>Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        @if ($produtos->isEmpty())
            <td colspan="7" class="text-center fs-6 text-break align-middle">Nenhum produto cadastrado.</td>
        @else
            @foreach($produtos as $produto)
            <tr class="produto-row" data-id="{{ $produto->id }}" data-produto="{{ json_encode(['id' => $produto->id, 'nome' => $produto->nome, 'categoria_id' => $produto->categoria_id, 'unidade_de_medida_id' => $produto->unidade_de_medida_id, 'quantidade' => $produto->quantidade, 'estoque' => $produto->estoque, 'descricao' => $produto->descricao, 'valor_unitario' => $produto->valor_unitario, 'imagem' => asset('storage/' . $produto->imagem)]) }}">
                <td><img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" width="75" height="50"></td>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->categoria->nome }}</td>
                <td>{{ $produto->unidade->abreviatura }}</td>
                <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                <td>{{ $produto->estoque }}</td>
                <td>
                    <button class="btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditarProduto">
                        Editar
                    </button>
                    <form action="{{ route('produtos.destroy', $produto->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        @endif
        </tbody>
    </table>

    <!-- Modal de Cadastro -->
    <div class="modal fade" id="modalCadastroProduto" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('produtos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="categoria_id" class="form-label">Categoria</label>
                            <select name="categoria_id" class="form-control">
                                @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="unidade_de_medida_id" class="form-label">Unidade de Medida</label>
                            <select name="unidade_de_medida_id" class="form-control">
                                @foreach($unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->abreviatura }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="imagem" class="form-label">Imagem</label>
                            <input type="file" class="form-control" name="imagem" required>
                        </div>
                        <div class="mb-3">
                            <label for="quantidade" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" name="quantidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="estoque" class="form-label">Estoque</label>
                            <input type="number" class="form-control" name="estoque" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="valor_unitario" class="form-label">Valor Unitário</label>
                            <input type="number" class="form-control" name="valor_unitario" step="0.01" required>
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
    <div class="modal fade" id="modalEditarProduto" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formEditarProduto" action="{{ isset($produto) ? route('produtos.update', $produto->id) : '#' }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editNome" class="form-label">Nome</label>
                            <input type="text" class="form-control" name="nome" id="editNome" required>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoria" class="form-label">Categoria</label>
                            <select name="categoria_id" class="form-control" id="editCategoria">
                                @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}">{{ $categoria->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editUnidade" class="form-label">Unidade de Medida</label>
                            <select name="unidade_de_medida_id" class="form-control" id="editUnidade">
                                @foreach($unidades as $unidade)
                                <option value="{{ $unidade->id }}">{{ $unidade->abreviatura }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="file" class="form-control" name="imagem" id="editImagem">
                        </div>
                        <div class="mb-3">
                            <label for="editQuantidade" class="form-label">Quantidade</label>
                            <input type="number" class="form-control" name="quantidade" id="editQuantidade" required>
                        </div>
                        <div class="mb-3">
                            <label for="editEstoque" class="form-label">Estoque</label>
                            <input type="number" class="form-control" name="estoque" id="editEstoque" required>
                        </div>
                        <div class="mb-3">
                            <label for="editDescricao" class="form-label">Descrição</label>
                            <textarea class="form-control" name="descricao" id="editDescricao" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editValorUnitario" class="form-label">Valor Unitário</label>
                            <input type="number" class="form-control" name="valor_unitario" id="editValorUnitario" step="0.01" required>
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
    document.querySelectorAll('.produto-row').forEach(row => {
        row.addEventListener('click', function() {
            const produto = JSON.parse(this.dataset.produto);
            document.getElementById('editNome').value = produto.nome;
            document.getElementById('editCategoria').value = produto.categoria_id;
            document.getElementById('editUnidade').value = produto.unidade_de_medida_id;
            document.getElementById('editQuantidade').value = produto.quantidade;
            document.getElementById('editEstoque').value = produto.estoque;
            document.getElementById('editDescricao').value = produto.descricao;
            document.getElementById('editValorUnitario').value = produto.valor_unitario;

            document.getElementById('formEditarProduto').action = `/produtos/${produto.id}`;
        });
    });

</script>

@endsection
