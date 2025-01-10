<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Endereco extends Model {
    protected $fillable = ['cliente_id', 'cep', 'rua', 'numero', 'complemento', 'bairro', 'cidade', 'estado'];

    public function cliente(): BelongsTo {
        return $this->belongsTo(Cliente::class);
    }
}