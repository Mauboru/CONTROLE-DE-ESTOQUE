<?php

namespace App\Exports;

use App\Models\Produto;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProdutosExport implements FromCollection
{
    public function collection()
    {
        return Produto::all();
    }
}
