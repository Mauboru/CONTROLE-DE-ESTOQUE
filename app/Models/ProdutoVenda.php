<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoVenda extends Model
{
    use HasFactory;

    // Nome da tabela (opcional, caso não siga a convenção de pluralização)
    protected $table = 'produto_venda';

    // Atributos que podem ser atribuídos em massa
    protected $fillable = [
        'venda_id',
        'produto_id',
        'quantidade',
        'valor_unitario',
        'valor_total',
    ];

    // Relação com a tabela 'Venda'
    public function venda()
    {
        return $this->belongsTo(Venda::class, 'venda_id');
    }

    // Relação com a tabela 'Produto'
    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
}
