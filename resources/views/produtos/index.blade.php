@extends('index')

@section('conteudo')

<div class="container">
    <h2 style="display: inline-block;">Produtos</h2>
    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalCadastroProduto" style="display: inline-block; margin-left: 10px;">
        +
    </button>

    <button type="button" class="btn btn-primary" style="display: inline-block; margin-left: 10px;" onclick="window.location.href='{{ route('gerarRelatorio') }}'">
        Gerar Relatório
    </button>

    <form method="GET" class="mb-3">
        <input type="text" name="nome" value="{{ request('nome') }}" class="form-control" placeholder="Buscar por nome">
    </form>

    <table class="table">
        <thead>
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
            @foreach($produtos as $produto)
            <tr>
                <td><img src="{{ asset('storage/' . $produto->imagem) }}" alt="{{ $produto->nome }}" width="50" height="50"></td>
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->categoria->nome }}</td>
                <td>{{ $produto->unidade->abreviatura }}</td>
                <td>R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</td>
                <td>{{ $produto->estoque }}</td>
                <td>
                    <button class=" btn btn-sm btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#modalEditarProduto" data-produto="{{ json_encode($produto) }}">
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
                        <!-- Campos do Formulário -->
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
                <form action="{{ route('produtos.update', 'produto_id') }}" method="POST" enctype="multipart/form-data" id="formEditarProduto">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Editar Produto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Campos do Formulário -->
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
                            <label for="editImagem" class="form-label">Imagem</label>
                            <img id="imagemAtual" src="" alt="Imagem atual" width="100" height="100" class="mb-2" />
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
    document.querySelectorAll('.btn-edit').forEach(btn => {
        btn.addEventListener('click', function() {
            const produto = JSON.parse(this.dataset.produto);

            document.getElementById('editNome').value = produto.nome;
            document.getElementById('editCategoria').value = produto.categoria_id;
            document.getElementById('editUnidade').value = produto.unidade_de_medida_id;
            document.getElementById('editQuantidade').value = produto.quantidade;
            document.getElementById('editEstoque').value = produto.estoque;
            document.getElementById('editDescricao').value = produto.descricao;
            document.getElementById('editValorUnitario').value = produto.valor_unitario;

            const imagemUrl = produto.imagem ? `/storage/${produto.imagem}` : '/path/to/default/image.png';
            document.getElementById('imagemAtual').src = imagemUrl;

            document.getElementById('formEditarProduto').action = `/produtos/${produto.id}`;
        });
    });
</script>

@endsection
