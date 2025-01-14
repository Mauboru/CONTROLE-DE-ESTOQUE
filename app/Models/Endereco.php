<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Endereco extends Model {
    protected $fillable = ['cliente_id', 'cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado'];

    public function cliente() {
        return $this->belongsTo(Cliente::class);
    }
}
