<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use App\Models\Categoria;
use App\Models\Unidade;
use App\Models\MovimentacaoEstoque;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProdutosExport;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProdutoController extends Controller {
    public function index(Request $request) {
        $produtos = Produto::all();
        $categorias = Categoria::all();
        $unidades = Unidade::all();
        
        return view('produtos.index', compact('produtos', 'categorias', 'unidades'));
    }

    public function store(Request $request) {
        $dados = $request->validate([
            'nome' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'unidade_de_medida_id' => 'required|exists:unidades,id',
            'imagem' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantidade' => 'required|integer',
            'estoque' => 'required|integer',
            'descricao' => 'required|string',
            'valor_unitario' => 'required|numeric',
        ]);
    
        $dados['caminho'] = 'produtos/' . uniqid() . '.jpg';
    
        $produto = Produto::create($dados);
    
        if ($request->hasFile('imagem')) {
            $produto->salvarImagem($request->file('imagem'));
        }
    
        return redirect()->route('produtos.index')->with('success', 'Produto cadastrado com sucesso.');
    }    

    public function update(Request $request, $id) {
        $request->validate([
            'nome' => 'required|string|max:255',
            'categoria_id' => 'required|exists:categorias,id',
            'unidade_de_medida_id' => 'required|exists:unidades,id',
            'quantidade' => 'required|integer',
            'estoque' => 'required|integer',
            'descricao' => 'required|string',
            'valor_unitario' => 'required|numeric',
        ]);
    
        $produto = Produto::findOrFail($id);
        $produto->nome = $request->nome;
        $produto->categoria_id = $request->categoria_id;
        $produto->unidade_de_medida_id = $request->unidade_de_medida_id;
        $produto->quantidade = $request->quantidade;
        $produto->estoque = $request->estoque;
        $produto->descricao = $request->descricao;
        $produto->valor_unitario = $request->valor_unitario;
    
        if ($request->hasFile('imagem')) {
            $produto->salvarImagem($request->file('imagem'));
        }
    
        $produto->save();
    
        return redirect()->route('produtos.index')->with('success', 'Produto atualizado com sucesso.');
    }    

    public function destroy($id) {
        $produto = Produto::findOrFail($id);
        try {
            $produto->delete();
            return redirect()->route('produtos.index')->with('success', 'Produto excluído com sucesso.');
        } catch (\Exception $e) {
            return redirect()->route('produtos.index')->with('error', 'Erro ao excluir produto: ' . $e->getMessage());
        }
    }

    public function darBaixaNoEstoque(Request $request, $id) {
        $request->validate([
            'quantidade' => 'required|integer|min:1',
            'motivo' => 'required|string|max:255',
        ]);

        $produto = Produto::findOrFail($id);

        if ($produto->estoque < $request->quantidade) {
            return redirect()->route('produtos.index')->with('error', 'Estoque insuficiente para dar baixa.');
        }

        $produto->estoque -= $request->quantidade;
        $produto->save();

        MovimentacaoEstoque::create([
            'produto_id' => $produto->id,
            'quantidade' => -$request->quantidade,
            'tipo' => $request->motivo,
        ]);

        return redirect()->route('produtos.index')->with('success', 'Baixa no estoque realizada com sucesso.');
    }
}
