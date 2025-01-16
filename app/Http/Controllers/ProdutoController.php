<?php

namespace App\Http\Controllers;

use App\Models\Produto;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProdutosExport;

class ProdutoController extends Controller {
    public function baixaEstoque(Request $request, $id) {
        $produto = Produto::findOrFail($id);
        $produto->quantidade -= $request->quantidade;
        $produto->save();

        return redirect()->back()->with('success', 'Baixa realizada com sucesso.');
    }

    public function gerarQRCode($id) {
        $produto = Produto::findOrFail($id);
        $qrcode = QrCode::size(300)->generate($produto->nome);
        return view('produtos.qrcode', compact('qrcode'));
    }

    // public function exportar() {
    //     return Excel::download(new ProdutosExport, 'produtos.xlsx');
    // }
}
