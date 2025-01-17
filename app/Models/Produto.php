<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Categoria;
use App\Models\Unidade;

class Produto extends Model
{
    protected $fillable = [
        'caminho',
        'imagem',
        'nome',
        'unidade_de_medida_id',
        'categoria_id',
        'quantidade',
        'estoque',
        'descricao',
        'valor_unitario',
    ];
}
