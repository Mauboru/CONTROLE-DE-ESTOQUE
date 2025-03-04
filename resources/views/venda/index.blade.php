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
        <h2>Vendas</h2>
    </div>

    <form method="GET" class="mb-3 d-flex justify-content-between align-items-center">
        <div class="w-50">
            <input type="text" name="nome" value="{{ request('nome') }}" class="form-control" placeholder="Buscar por nome">
        </div>
        <div>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCadastroVenda">
                <i class="bi bi-plus"></i> Nova Venda
            </button>
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#modalRelatorio">
                <i class="bi bi-file-earmark-bar-graph"></i> Relatório
            </button>
        </div>
    </form>

    <!-- Tabela -->
    <table class="table table-striped table-hover text-center w-100">
        <thead class="table-light">
            <tr>
                <th>Cliente</th>
                <th>Data da Venda</th>
                <th>Valor Total</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vendas as $venda)
            <tr class="venda-row" data-id="{{ $venda->id }}" data-venda="{{ json_encode($venda) }}">
                <td>{{ $venda->cliente->nome }}</td>
                <td>{{ $venda->data_venda }}</td>
                <td>R$ {{ number_format($venda->valor_total, 2, ',', '.') }}</td>
                <td>
                    <button class="btn btn-sm btn-secondary btn-edit"
                        data-bs-toggle="modal"
                        data-bs-target="#modalDetalhes"
                        data-venda-id="{{ $venda->id }}"
                        data-qrcode-path="{{ $venda->qrcode_path }}">
                        Detalhes
                    </button>
                    <form action="{{ route('vendas.destroy', $venda->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">Nenhuma venda encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Modal de Cadastro -->
    <div class="modal fade" id="modalCadastroVenda" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('vendas.store') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title">Cadastrar Venda</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="cliente_id" class="form-label">Cliente</label>
                            <select name="cliente_id" class="form-control" required>
                                <option value="">Selecione o Cliente</option>
                                @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <h4>Produtos</h4>
                        <div class="mb-3" id="produtos">
                            <div class="produto-item">
                                <label for="produto_id" class="form-label">Produto</label>
                                <select name="produtos[0][id]" class="form-control" required>
                                    <option value="">Selecione o Produto</option>
                                    @foreach($produtos as $produto)
                                    <option value="{{ $produto->id }}">
                                        {{ $produto->nome }} - R$ {{ number_format($produto->valor_unitario, 2, ',', '.') }}
                                    </option>
                                    @endforeach
                                </select>

                                <label for="quantidade" class="form-label">Quantidade</label>
                                <input type="number" name="produtos[0][quantidade]" class="form-control" required min="1" value="1">
                            </div>
                        </div>
                        <button type="button" id="add-produto" class="btn btn-secondary">Adicionar Produto</button>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Finalizar Venda</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Detalhes -->
    <div class="modal fade" id="modalDetalhes" tabindex="-1">
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

    <!-- Modal de Relatório -->
    <div class="modal fade" id="modalRelatorio" tabindex="-1" aria-labelledby="modalRelatorioLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('relatorios') }}" method="GET">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRelatorioLabel">Gerar Relatório</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
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
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const tipoRelatorioSelect = document.getElementById('tipo_relatorio');
        const clienteSelectDiv = document.querySelector('.cliente-select');
        const periodoSelectDiv = document.querySelector('.periodo-select');

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
                        const qrCodeImage = document.getElementById('qr-code');
                        if (data.qrCodePath) {
                            qrCodeImage.src = data.qrCodePath;
                            qrCodeImage.style.display = 'block';
                        } else {
                            qrCodeImage.style.display = 'none';
                        }
                    })
                    .catch(error => console.error('Erro ao carregar detalhes:', error));
            });
        });
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
        document.getElementById('tipo_relatorio').addEventListener('change', function() {
            const clienteSelectDiv = document.querySelector('.cliente-select');
            const periodoSelectDiv = document.querySelector('.periodo-select');

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
