<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $dates = ['data_venda'];
    
    protected $fillable = [
        'cliente_id',
        'data_venda',
        'valor_total',
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_venda', 'venda_id', 'produto_id')
        ->withPivot('quantidade', 'valor_unitario', 'valor_total')
        ->withTimestamps();
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
