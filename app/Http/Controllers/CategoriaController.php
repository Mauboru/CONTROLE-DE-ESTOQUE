<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriaController extends Controller {
    public function index(Request $request) {
        $query = Categoria::query();

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        $categorias = $query->with('endereco')->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|max:255',
            'telefone' => 'required|numeric',
            'cpf' => 'required|digits:11|unique:categorias',
            'email' => 'required|email|unique:categorias',
            'cep' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $categoria = Categoria::create($request->only(['nome', 'telefone', 'cpf', 'email']));
            $categoria->endereco()->create($request->only(['cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado']));

            DB::commit();

            return redirect()->route('categorias.index')->with('success', 'Categoria cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categorias.index')->with('error', 'Erro ao cadastrar categoria: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nome' => 'required|max:255',
            'telefone' => 'required|numeric',
            'cpf' => 'required|digits:11|unique:categorias,cpf,' . $categoria->id,
            'email' => 'required|email|unique:categorias,email,' . $categoria->id,
            'cep' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $categoria->update($request->only(['nome', 'telefone', 'cpf', 'email']));
            $categoria->endereco->update($request->only(['cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado']));

            DB::commit();

            return redirect()->route('categorias.index')->with('success', 'Categoria atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categorias.index')->with('error', 'Erro ao atualizar categoria: ' . $e->getMessage());
        }
    }

    public function destroy($id) {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();

        return redirect()->route('categorias.index')->with('success', 'Categoria excluído com sucesso!');
    }
}
