<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller {
    public function index(Request $request) {
        $query = Cliente::query();

        if ($request->filled('nome')) {
            $query->where('nome', 'like', '%' . $request->nome . '%');
        }
        $clientes = $query->with('endereco')->paginate(10);

        return view('clientes.index', compact('clientes'));
    }

    public function show($id) {
        $cliente = Cliente::with('endereco')->findOrFail($id);
        return response()->json($cliente);
    }    

    public function store(Request $request) {
        $request->validate([
            'nome' => 'required|max:255',
            'telefone' => 'required|numeric',
            'cpf' => 'required|digits:11|unique:clientes',
            'email' => 'required|email|unique:clientes',
            'cep' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $cliente = Cliente::create($request->only(['nome', 'telefone', 'cpf', 'email']));
            $cliente->endereco()->create($request->only(['cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado']));

            DB::commit();

            return redirect()->route('clientes.index')->with('success', 'Cliente cadastrado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            dd(1);
            return redirect()->route('clientes.index')->with('error', 'Erro ao cadastrar cliente: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id) {
        $cliente = Cliente::findOrFail($id);

        $request->validate([
            'nome' => 'required|max:255',
            'telefone' => 'required|numeric',
            'cpf' => 'required|digits:11|unique:clientes,cpf,' . $cliente->id,
            'email' => 'required|email|unique:clientes,email,' . $cliente->id,
            'cep' => 'required',
            'rua' => 'required',
            'numero' => 'required',
            'bairro' => 'required',
            'cidade' => 'required',
            'estado' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $cliente->update($request->only(['nome', 'telefone', 'cpf', 'email']));
            $cliente->endereco->update($request->only(['cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado']));

            DB::commit();

            return redirect()->route('clientes.index')->with('success', 'Cliente atualizado com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('clientes.index')->with('error', 'Erro ao atualizar cliente: ' . $e->getMessage());
        }
    }

    public function destroy($id) {
        $cliente = Cliente::findOrFail($id);
        try {
            $cliente->delete();
            return redirect()->route('clientes.index')->with('success', 'Cliente excluído com sucesso!');
        } catch (\Exception $e) {
            return redirect()->route('clientes.index')->with('error', 'Erro ao excluir clientes: ' . $e->getMessage());
        }
    }
}
