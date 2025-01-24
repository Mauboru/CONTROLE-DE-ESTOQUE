@extends('index')

@section('conteudo')

<div class="container">
    <h3>Registrar Venda</h3>

    <!-- Modal de Sucesso -->
    @if(session('success'))
    <div class="modal fade" id="modalSuccess" tabindex="-1" aria-labelledby="modalSuccessLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalSuccessLabel">Sucesso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('success') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de Erro -->
    @if(session('error'))
    <div class="modal fade" id="modalError" tabindex="-1" aria-labelledby="modalErrorLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalErrorLabel">Erro</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{ session('error') }}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>
    @endif

    <form action="{{ route('vendas.store') }}" method="POST">
        @csrf

        <!-- Selecionar Cliente -->
        <div class="form-group">
            <label for="cliente_id">Cliente</label>
            <select name="cliente_id" class="form-control" required>
                <option value="">Selecione o Cliente</option>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>

        <!-- Produtos -->
        <h4>Produtos</h4>
        <div class="form-group" id="produtos">
            <div class="produto-item">
                <label for="produto_id">Produto</label>
                <select name="produtos[0][id]" class="form-control" required>
                    <option value="">Selecione o Produto</option>
                    @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}</option>
                    @endforeach
                </select>

                <label for="quantidade">Quantidade</label>
                <input type="number" name="produtos[0][quantidade]" class="form-control" required min="1" value="1">
            </div>
        </div>

        <!-- Adicionar mais produtos -->
        <button type="button" id="add-produto" class="btn btn-secondary">Adicionar Produto</button>

        <br><br>
        <button type="submit" class="btn btn-primary">Finalizar Venda</button>
    </form>

    <h3 class="mt-5">Vendas Realizadas</h3>
    <table class="table">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Data da Venda</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach($vendas as $venda)
            <tr>
                <td>{{ $venda->cliente->nome }}</td>
                <td>{{ $venda->data_venda }}</td>
                <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                <td>
                    <a href="#" class="btn btn-info btn-sm">Detalhes</a>
                    <form action="{{ route('vendas.destroy', $venda->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Excluir</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Paginação -->
    {{ $vendas->links() }}

</div>

<script>
    // Mostrar a modal de sucesso ou erro automaticamente
    @if(session('success'))
    var myModalSuccess = new bootstrap.Modal(document.getElementById('modalSuccess'), {});
    myModalSuccess.show();
    @elseif(session('error'))
    var myModalError = new bootstrap.Modal(document.getElementById('modalError'), {});
    myModalError.show();
    @endif

    document.getElementById('add-produto').addEventListener('click', function() {
        const produtosDiv = document.getElementById('produtos');
        const index = produtosDiv.children.length;
        const newProdutoDiv = document.createElement('div');
        newProdutoDiv.classList.add('produto-item');
        newProdutoDiv.innerHTML = `
            <label for="produto_id">Produto</label>
            <select name="produtos[${index}][id]" class="form-control" required>
                <option value="">Selecione o Produto</option>
                @foreach($produtos as $produto)
                    <option value="{{ $produto->id }}">{{ $produto->nome }} - R$ {{ number_format($produto->preco, 2, ',', '.') }}</option>
                @endforeach
            </select>

            <label for="quantidade">Quantidade</label>
            <input type="number" name="produtos[${index}][quantidade]" class="form-control" required min="1" value="1">
        `;
        produtosDiv.appendChild(newProdutoDiv);
    });
</script>

@endsection
