@extends('index')

@section('conteudo')
<h3>Relatório de Retiradas por Período</h3>
<table class="table">
    <thead>
        <tr>
            <th>Nome do Produto</th>
            <th>Quantidade Retirada</th>
            <th>Cliente</th>
            <th>Data da Retirada</th>
            <th>Valor Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach($vendas as $venda)
        @foreach($venda->produtos as $produto)
        <tr>
            <td>{{ $produto->nome }}</td>
            <td>{{ $produto->pivot->quantidade }}</td>
            <td>{{ $venda->cliente->nome }}</td>
            <td>{{ $venda->data_venda }}</td>
            <td>R$ {{ number_format($produto->pivot->valor_total, 2, ',', '.') }}</td>
        </tr>
        @endforeach
        @endforeach
    </tbody>
</table>
@endsection
