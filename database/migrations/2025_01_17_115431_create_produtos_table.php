<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProdutosTable extends Migration
{
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('caminho');
            $table->string('imagem')->nullable();
            $table->string('nome');
            $table->foreignId('unidade_de_medida_id')->constrained('unidades')->onDelete('cascade');;
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');;
            $table->integer('quantidade');
            $table->integer('estoque');
            $table->text('descricao');
            $table->decimal('valor_unitario', 10, 2);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
