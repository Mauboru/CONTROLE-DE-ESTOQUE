<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovimentacaoEstoque extends Model
{
    use HasFactory;
    protected $table = 'movimentacoes_estoque';
    protected $fillable = [
        'produto_id',
        'quantidade',
        'tipo',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
