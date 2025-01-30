@extends('index')

@section('conteudo')
<div class="container mt-4">
    <h3 class="mb-4 text-center">Relatório de Produtos sem Estoque</h3>

    <table class="table table-striped table-bordered table-hover table-sm">
        <thead class="thead-dark">
            <tr class="text-center align-middle">
                <th>Nome do Produto</th>
                <th>Unidade</th>
                <th>Categoria</th>
                <th>Data de Saída (Estoque Finalizado)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produtos as $produto)
            @foreach($produtos as $produto)
            <tr class="text-center fs-6 text-break align-middle">
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->unidade }}</td>
                <td>{{ $produto->categoria }}</td>
                <td>{{ $produto->updated_at }}</td>
            </tr>
            @endforeach
            @empty
            <tr>
                <td colspan="7" class="text-center fs-6 text-break align-middle">Nenhum produto sem estoque.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endsection
