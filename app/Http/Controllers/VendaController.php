<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Models\Produto;
use App\Models\ProdutoVenda;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VendaController extends Controller {
    public function index(Request $request) {
        $query = Venda::with('cliente');
        if ($request->filled('nome')) {
            $query->whereHas('cliente', function ($q) use ($request) {
                $q->where('nome', 'like', '%' . $request->nome . '%');
            });
        }
        $vendas = $query->paginate(10);
        $clientes = Cliente::all();
        $produtos = Produto::all();

        return view('venda.index', compact('vendas', 'clientes', 'produtos'));
    }

    public function store(Request $request) {
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
            $qrData = [
                'Venda ID' => $venda->id,
                'Cliente' => $venda->cliente->nome,
                'Data' => $venda->data_venda,
                'Valor Total' => 'R$ ' . number_format($venda->valor_total, 2, ',', '.'),
                'Produtos' => $venda->produtos->map(function ($produto) {
                    return $produto->nome . ' (Qtd: ' . $produto->pivot->quantidade . ')';
                })->join(', '),
            ];

            $qrCodePath = 'qr_codes/venda_' . $venda->id . '.svg';
            QrCode::size(200)->format('svg')->generate(json_encode($qrData), public_path($qrCodePath));
            $venda->qr_code_path = $qrCodePath;
            $venda->save();

            DB::commit();

            return redirect()->route('vendas.index')->with('success', 'Venda registrada com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vendas.index')->with('error', 'Erro ao registrar a venda: ' . $e->getMessage());
        }
    }

    public function destroy($id) {
        DB::beginTransaction();
        try {
            $venda = Venda::findOrFail($id);
            $produtosVenda = ProdutoVenda::where('venda_id', $id)->get();
            foreach ($produtosVenda as $produtoVenda) {
                $produto = Produto::find($produtoVenda->produto_id);
                $produto->estoque += $produtoVenda->quantidade;
                $produto->save();
            }
            ProdutoVenda::where('venda_id', $id)->delete();
            $venda->delete();
            DB::commit();
            return redirect()->route('vendas.index')->with('success', 'Venda excluída com sucesso!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('vendas.index')->with('error', 'Erro ao excluir a venda: ' . $e->getMessage());
        }
    }

    public function detalhes($id) {
        $venda = Venda::with('cliente', 'produtos')->find($id);

        if (!$venda) {
            return response()->json(['error' => 'Venda não encontrada'], 404);
        }
        $qrCodePath = session('qrCodePath');

        return response()->json([
            'cliente' => $venda->cliente->nome,
            'data_venda' => $venda->data_venda,
            'valor_total' => number_format($venda->valor_total, 2, ',', '.'),
            'produtos' => $venda->produtos->map(function ($produto) {
                return $produto->nome . ' - Quantidade: ' . $produto->pivot->quantidade;
            })->join(', '),
            'qrCodePath' => asset($venda->qr_code_path)
        ]);
    }

    public function relatorios(Request $request) {
        $tipoRelatorio = $request->input('tipo_relatorio');
        $periodo = $request->input('periodo');
        $cliente = $request->input('cliente_id');

        switch ($tipoRelatorio) {
            case 'retiradas_periodo':
                return $this->relatorioRetiradasPorPeriodo($periodo);
            case 'retiradas_cliente':
                return $this->relatorioRetiradasPorCliente($cliente);
            case 'produtos_sem_estoque':
                return $this->relatorioProdutosSemEstoque();
            case 'produtos_com_estoque':
                return $this->relatorioProdutosComEstoque();
            default:
                return redirect()->back()->with('error', 'Tipo de relatório inválido.');
        }
    }

    private function relatorioRetiradasPorPeriodo($periodo) {
        $dataInicio = $this->getDataInicioPorPeriodo($periodo);

        $vendas = Venda::where('data_venda', '>=', $dataInicio)
            ->with('cliente', 'produtos')
            ->get();
        return view('relatorios.retiradas_por_periodo', compact('vendas'));
    }

    private function getDataInicioPorPeriodo($periodo) {
        switch ($periodo) {
            case 'diario':
                return now()->subDay()->startOfDay();
            case 'semanal':
                return now()->startOfWeek();
            case 'mensal':
                return now()->startOfMonth();
            default:
                return now()->subDay()->startOfDay();
        }
    }

    private function relatorioRetiradasPorCliente($clienteId) {
        $query = Venda::with('cliente', 'produtos');

        if ($clienteId) {
            $query->where('cliente_id', $clienteId);
            $clientes = Cliente::where('id', $clienteId)->get();
        } else {
            $clientes = Cliente::all();
        }

        $vendas = $query->get();

        return view('relatorios.retiradas_por_cliente', compact('vendas', 'clientes'));
    }

    private function relatorioProdutosSemEstoque() {
        $produtos = Produto::where('estoque', 0)->get();

        return view('relatorios.produtos_sem_estoque', compact('produtos'));
    }

    private function relatorioProdutosComEstoque() {
        $produtos = Produto::where('estoque', '>', 0)->get();

        return view('relatorios.produtos_com_estoque', compact('produtos'));
    }
}
