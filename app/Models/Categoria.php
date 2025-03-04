<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {
    protected $fillable = ['nome', 'descricao'];

    public $timestamps = true;

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
