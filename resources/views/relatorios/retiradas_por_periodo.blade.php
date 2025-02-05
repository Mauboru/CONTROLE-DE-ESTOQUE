@extends('index')

@section('conteudo')
<div class="container mt-4">
    <h3 class="mb-4 text-center">Relatório de Retiradas por Período</h3>

    <table class="table table-striped table-bordered table-hover table-sm">
        <thead class="thead-dark">
            <tr class="text-center align-middle">
                <th>Nome do Produto</th>
                <th>Quantidade Retirada</th>
                <th>Cliente</th>
                <th>Data da Retirada</th>
                <th>Valor Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($vendas as $venda)
            @foreach($vendas as $venda)
            @foreach($venda->produtos as $produto)
            <tr class="text-center fs-6 text-break align-middle">
                <td>{{ $produto->nome ?? 'Produto não identificado' }}</td>
                <td>{{ $produto->pivot->quantidade ?? '0' }}</td>
                <td>{{ $venda->cliente->nome ?? 'Cliente não identificado' }}</td>
                <td>{{ \Carbon\Carbon::parse($venda->data_venda)->format('d/m/Y H:i') }}</td>
                <td>R$ {{ number_format($produto->pivot->valor_total ?? 0, 2, ',', '.') }}</td>
            </tr>
            @endforeach
            @endforeach
            @empty
            <tr>
                <td colspan="7" class="text-center fs-6 text-break align-middle">Nenhuma retirada por período.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endsection