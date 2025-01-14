<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
    protected $fillable = ['nome', 'telefone', 'cpf', 'email'];

    public function endereco() {
        return $this->hasOne(Endereco::class);
    }
}
