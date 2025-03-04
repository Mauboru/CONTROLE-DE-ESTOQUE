@extends('index')

@section('conteudo')
<div class="container mt-4">
    <h3 class="mb-4 text-center">Relatório de Produtos com Estoque</h3>

    <table class="table table-striped table-bordered table-hover table-sm">
        <thead class="thead-dark">
            <tr class="text-center align-middle">
                <th>Nome do Produto</th>
                <th>Estoque</th>
                <th>Categoria</th>
                <th>Data de Saída</th>
            </tr>
        </thead>
        <tbody>
            @forelse($produtos as $produto)
            <tr class="text-center fs-6 text-break align-middle">
                <td>{{ $produto->nome }}</td>
                <td>{{ $produto->estoque ?? '0' }}</td>
                <td>{{ $produto->categoria->nome ?? '-' }}</td>
                <td>{{ $produto->updated_at->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i:s') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center fs-6 text-break align-middle">Nenhum produto com estoque.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    @endsection