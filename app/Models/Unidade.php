<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unidade extends Model
{
    protected $fillable = [
        'abreviatura',
        'descricao'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class);
    }
}
