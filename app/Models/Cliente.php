<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cliente extends Model {
    protected $fillable = ['nome', 'telefone', 'cpf', 'email'];

    public function endereco(): HasOne {
        return $this->hasOne(Endereco::class);
    }
}