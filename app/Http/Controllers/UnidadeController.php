<?php

namespace App\Http\Controllers;

use App\Models\Unidade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UnidadeController extends Controller
{
    public function index(Request $request)
    {
        $query = Unidade::query();

        if ($request->filled('abreviatura')) {
            $query->where('abreviatura', 'like', '%' . $request->abreviatura . '%');
        }
        $unidades = $query->paginate(10);

        return view('unidades.index', compact('unidades'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'abreviatura' => 'required|max:10|unique:unidades',
            'descricao' => 'required|max:255',
        ]);

        DB::beginTransaction();

        try {
            Unidade::create($request->only(['abreviatura', 'descricao']));
            DB::commit();
            return redirect()->route('unidades.index')->with('success', 'Unidade cadastrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('unidades.index')->with('error', 'Erro ao cadastrar unidade: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $unidade = Unidade::findOrFail($id);

        $request->validate([
            'abreviatura' => 'required|max:10|unique:unidades,abreviatura,' . $unidade->id,
            'descricao' => 'required|max:255',
        ]);

        DB::beginTransaction();

        try {
            $unidade->update($request->only(['abreviatura', 'descricao']));
            DB::commit();
            return redirect()->route('unidades.index')->with('success', 'Unidade atualizada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('unidades.index')->with('error', 'Erro ao atualizar unidade: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $unidade = Unidade::findOrFail($id);
        $unidade->delete();

        return redirect()->route('unidades.index')->with('success', 'Unidade excluída com sucesso!');
    }
}
