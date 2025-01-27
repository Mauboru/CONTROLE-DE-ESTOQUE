@extends('index')

@section('conteudo')
<h3>Relatório de Produtos sem Estoque</h3>
<table class="table">
    <thead>
        <tr>
            <th>Nome do Produto</th>
            <th>Unidade</th>
            <th>Categoria</th>
            <th>Data de Saída (Estoque Finalizado)</th>
        </tr>
    </thead>
    <tbody>
        @foreach($produtos as $produto)
        <tr>
            <td>{{ $produto->nome }}</td> <!-- Nome do Produto -->
            <td>{{ $produto->unidade }}</td> <!-- Unidade do Produto -->
            <td>{{ $produto->categoria }}</td> <!-- Categoria do Produto -->
            <td>{{ $produto->updated_at }}</td> <!-- Data da última atualização -->
        </tr>
        @endforeach
    </tbody>
</table>
@endsection
