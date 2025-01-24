<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VendaController extends Controller
{
    public function index()
    {
        $vendas = Venda::with('cliente')->paginate(10);
        $clientes = Cliente::all();
        $produtos = Produto::all();

        return view('venda.index', compact('vendas', 'clientes', 'produtos'));
    }
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $venda = Venda::create([
                'cliente_id' => $request->cliente_id,
                'data_venda' => now(),
                'valor_total' => 0,
            ]);

            $produtos = $request->produtos;

            foreach ($produtos as $produto) {
                $produtoModel = Produto::findOrFail($produto['id']);

                if ($produtoModel->estoque < $produto['quantidade']) {
                    throw new \Exception("Estoque insuficiente para o produto: {$produtoModel->nome}");
                }

                $valorUnitario = $produtoModel->valor_unitario;

                $valorTotal = $valorUnitario * $produto['quantidade'];

                $venda->produtos()->attach($produto['id'], [
                    'quantidade' => $produto['quantidade'],
                    'valor_unitario' => $valorUnitario,
                    'valor_total' => $valorTotal,
                ]);

                $produtoModel->estoque -= $produto['quantidade'];
                $produtoModel->save();
            }

            $venda->valor_total = $venda->produtos->sum(function ($produto) {
                return $produto->pivot->valor_total;
            });

            $venda->save();

            DB::commit();

            return redirect()->route('vendas.index')->with('success', 'Venda registrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vendas.index')->with('error', 'Erro ao registrar a venda: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $venda = Venda::findOrFail($id);
            $venda->delete();

            DB::commit();
            return redirect()->route('vendas.index')->with('success', 'Venda excluída com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vendas.index')->with('error', 'Erro ao excluir a venda: ' . $e->getMessage());
        }
    }
}
