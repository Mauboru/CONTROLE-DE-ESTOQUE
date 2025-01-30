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
                    @if(session('qrCodePath'))
                    <div class="mt-3">
                        <h4>QR Code da Venda</h4>
                        <img src="{{ asset(session('qrCodePath')) }}" alt="QR Code" />
                    </div>
                    @endif
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

    <!-- Modal de Detalhes da Venda -->
    <div class="modal fade" id="modalDetalhes" tabindex="-1" aria-labelledby="modalDetalhesLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalDetalhesLabel">Detalhes da Venda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="venda-detalhes">
                    </div>
                    <div class="mt-3" id="qr-code-container">
                        <h5>QR Code da Venda</h5>
                        <img src="" id="qr-code" alt="QR Code" style="width: 200px;" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

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
                    <option value="{{ $produto->id }}">{{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}</option>
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

    <h3>Relatórios</h3>
    <form action="{{ route('relatorios') }}" method="GET">
        <div class="form-group">
            <label for="tipo_relatorio">Tipo de Relatório</label>
            <select name="tipo_relatorio" id="tipo_relatorio" class="form-control" required>
                <option value="retiradas_periodo">Retiradas por Período</option>
                <option value="retiradas_cliente">Retiradas por Cliente</option>
                <option value="produtos_sem_estoque">Produtos sem Estoque</option>
                <option value="produtos_com_estoque">Produtos com Estoque</option>
            </select>
        </div>
        <div class="form-group periodo-select d-none">
            <label for="periodo">Período</label>
            <select name="periodo" id="periodo" class="form-control" required>
                <option value="diario">Diário</option>
                <option value="semanal">Semanal</option>
                <option value="mensal">Mensal</option>
            </select>
        </div>
        <div class="form-group cliente-select d-none">
            <label for="cliente">Cliente</label>
            <select name="cliente_id" id="cliente_id" class="form-control">
                <option value="">Todos os Clientes</option>
                @foreach($clientes as $cliente)
                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Gerar Relatório</button>
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
                    <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#modalDetalhes"
                        data-venda-id="{{ $venda->id }}"
                        data-qrcode-path="{{ asset('qr_codes/venda_' . $venda->id . '.svg') }}">
                        Detalhes
                    </button>
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
</div>

<script>
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

    document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#modalDetalhes"]').forEach(button => {
        button.addEventListener('click', function(event) {
            const vendaId = event.currentTarget.getAttribute('data-venda-id');
            const qrCodePath = event.currentTarget.getAttribute('data-qrcode-path');

            fetch(`/vendas/${vendaId}/detalhes`)
                .then(response => response.json())
                .then(data => {
                    const detalhesContainer = document.getElementById('venda-detalhes');
                    detalhesContainer.innerHTML = `
                    <p><strong>Cliente:</strong> ${data.cliente}</p>
                    <p><strong>Data da Venda:</strong> ${data.data_venda}</p>
                    <p><strong>Valor Total:</strong> ${data.valor_total}</p>
                    <p><strong>Produtos:</strong> ${data.produtos}</p>
                `;
                })
                .catch(error => console.error('Erro ao carregar detalhes:', error));

            const qrCodeImage = document.getElementById('qr-code');
            qrCodeImage.src = qrCodePath;
        });
    });

    const tipoRelatorioSelect = document.getElementById('tipo_relatorio');
    const clienteSelectDiv = document.querySelector('.cliente-select');
    const periodoSelectDiv = document.querySelector('.periodo-select');

    tipoRelatorioSelect.addEventListener('change', function() {
        if (this.value === 'retiradas_cliente') {
            clienteSelectDiv.classList.remove('d-none');
        } else {
            clienteSelectDiv.classList.add('d-none');
        }
        if (this.value === 'retiradas_periodo') {
            periodoSelectDiv.classList.remove('d-none');
        } else {
            periodoSelectDiv.classList.add('d-none');
        }
    });
</script>

@endsection
