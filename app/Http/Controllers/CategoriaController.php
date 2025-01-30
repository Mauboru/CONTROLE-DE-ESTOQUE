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
        $categorias = $query->paginate(10);

        return view('categorias.index', compact('categorias'));
    }

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'required|max:500',
        ]);

        DB::beginTransaction();

        try {
            $categoria = Categoria::create($request->only(['nome', 'descricao']));

            DB::commit();

            return redirect()->route('categorias.index')->with('success', 'Categoria cadastrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categorias.index')->with('error', 'Erro ao cadastrar categoria: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        $categoria = Categoria::findOrFail($id);

        $request->validate([
            'nome' => 'required|max:255',
            'descricao' => 'required|max:500',
        ]);

        DB::beginTransaction();

        try {
            $categoria->update($request->only(['nome', 'descricao']));

            DB::commit();

            return redirect()->route('categorias.index')->with('success', 'Categoria atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('categorias.index')->with('error', 'Erro ao atualizar categoria: ' . $e->getMessage());
        }
    }

    public function destroy($id) {
        $categoria = Categoria::findOrFail($id);
        try {
            $categoria->delete();
            return redirect()->route('categorias.index')->with('success', 'Categoria excluída com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('categorias.index')->with('error', 'Erro ao excluir categoria: ' . $e->getMessage());
        }
    }
}
